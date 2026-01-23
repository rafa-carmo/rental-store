<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemTypeRequest;
use App\Http\Requests\UpdateItemTypeRequest;
use App\Models\ItemType;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $itemTypes = ItemType::query()
            ->orderBy('name')
            ->get();

        return Inertia::render('ItemTypes/Index', [
            'itemTypes' => $itemTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('ItemTypes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemTypeRequest $request): RedirectResponse
    {
        ItemType::create($request->validated());

        return redirect()->route('item-types.index')
            ->with('success', 'Tipo de item criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemType $itemType): Response
    {
        return Inertia::render('ItemTypes/Edit', [
            'itemType' => $itemType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemTypeRequest $request, ItemType $itemType): RedirectResponse
    {
        $data = $request->validated();
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        $itemType->update($data);

        return redirect()->route('item-types.index')
            ->with('success', 'Tipo de item atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemType $itemType): RedirectResponse
    {
        $itemType->delete();

        return redirect()->route('item-types.index')
            ->with('success', 'Tipo de item excluído com sucesso!');
    }
}
