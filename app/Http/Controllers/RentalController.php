<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentalRequest;
use App\Http\Requests\UpdateRentalRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Rental;
use Illuminate\Http\RedirectResponse;
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
        $items = Item::query()->orderBy('name')->get();

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
        Rental::create($request->validated());

        return redirect()->route('rentals.index')
            ->with('success', 'Aluguel criado com sucesso!');
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
        $rental->delete();

        return redirect()->route('rentals.index')
            ->with('success', 'Aluguel excluído com sucesso!');
    }

    /**
     * Mark rental as returned.
     */
    public function markAsReturned(Rental $rental): RedirectResponse
    {
        $rental->update(['returned_at' => now()]);

        return redirect()->route('rentals.index')
            ->with('success', 'Devolução registrada com sucesso!');
    }
}
