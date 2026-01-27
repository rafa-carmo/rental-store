<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentalRequest;
use App\Http\Requests\UpdateRentalRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Rental;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $rentals = Rental::query()
            ->with(['customer', 'item'])
            ->orderBy('pickup_date', 'desc')
            ->get();

        return Inertia::render('Rentals/Index', [
            'rentals' => $rentals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $customers = Customer::query()->orderBy('name')->get();
        $items = Item::query()
            ->where('quantity_available', '>', 0)
            ->orderBy('name')
            ->get();

        return Inertia::render('Rentals/Create', [
            'customers' => $customers,
            'items' => $items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRentalRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();

                $item = Item::findOrFail($validated['item_id']);

                if (! $item->hasAvailableQuantity()) {
                    throw new \Exception('Item não possui quantidade disponível.');
                }

                Rental::create($validated);
                $item->decreaseQuantity();
            });

            return redirect()->route('rentals.index')
                ->with('success', 'Aluguel criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['item_id' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental): Response
    {
        $customers = Customer::query()->orderBy('name')->get();
        $items = Item::query()->orderBy('name')->get();

        return Inertia::render('Rentals/Edit', [
            'rental' => $rental->load(['customer', 'item']),
            'customers' => $customers,
            'items' => $items,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRentalRequest $request, Rental $rental): RedirectResponse
    {
        $rental->update($request->validated());

        return redirect()->route('rentals.index')
            ->with('success', 'Aluguel atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental): RedirectResponse
    {
        DB::transaction(function () use ($rental) {
            // If rental was not returned, restore item quantity
            if ($rental->returned_at === null) {
                $rental->item->increaseQuantity();
            }

            $rental->delete();
        });

        return redirect()->route('rentals.index')
            ->with('success', 'Aluguel excluído com sucesso!');
    }

    /**
     * Mark rental as returned.
     */
    public function markAsReturned(Rental $rental): RedirectResponse
    {
        DB::transaction(function () use ($rental) {
            if ($rental->returned_at === null) {
                $rental->update(['returned_at' => now()]);
                $rental->item->increaseQuantity();
            }
        });

        return redirect()->route('rentals.index')
            ->with('success', 'Devolução registrada com sucesso!');
    }
}
