<?php

use App\Models\Customer;
use App\Models\Item;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('has available quantity check', function () {
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 3,
    ]);

    expect($item->hasAvailableQuantity())->toBeTrue();

    $itemNoStock = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 0,
    ]);

    expect($itemNoStock->hasAvailableQuantity())->toBeFalse();
});

it('decreases quantity when renting', function () {
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 5,
        'status' => 'disponivel',
    ]);

    $item->decreaseQuantity();

    expect($item->quantity_available)->toBe(4)
        ->and($item->status)->toBe('disponivel');
});

it('changes status to alugado when quantity reaches zero', function () {
    $item = Item::factory()->create([
        'quantity_total' => 1,
        'quantity_available' => 1,
        'status' => 'disponivel',
    ]);

    $item->decreaseQuantity();

    expect($item->quantity_available)->toBe(0)
        ->and($item->status)->toBe('alugado');
});

it('increases quantity when returning', function () {
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 3,
        'status' => 'disponivel',
    ]);

    $item->increaseQuantity();

    expect($item->quantity_available)->toBe(4)
        ->and($item->status)->toBe('disponivel');
});

it('changes status to disponivel when increasing quantity from zero', function () {
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 0,
        'status' => 'alugado',
    ]);

    $item->increaseQuantity();

    expect($item->quantity_available)->toBe(1)
        ->and($item->status)->toBe('disponivel');
});

it('does not increase quantity beyond total', function () {
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 5,
    ]);

    $item->increaseQuantity();

    expect($item->quantity_available)->toBe(5);
});

it('does not decrease quantity below zero', function () {
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 0,
    ]);

    $item->decreaseQuantity();

    expect($item->quantity_available)->toBe(0);
});

it('decreases item quantity when creating rental', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $customer = Customer::factory()->create();
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 5,
        'status' => 'disponivel',
    ]);

    actingAs($user)
        ->post(route('rentals.store'), [
            'customer_id' => $customer->id,
            'item_id' => $item->id,
            'value' => 100.00,
            'pickup_date' => now()->toDateString(),
            'return_date' => now()->addDays(3)->toDateString(),
        ])
        ->assertRedirect(route('rentals.index'));

    $item->refresh();

    expect($item->quantity_available)->toBe(4);
});

it('changes item status to alugado when last unit is rented', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $customer = Customer::factory()->create();
    $item = Item::factory()->create([
        'quantity_total' => 1,
        'quantity_available' => 1,
        'status' => 'disponivel',
    ]);

    actingAs($user)
        ->post(route('rentals.store'), [
            'customer_id' => $customer->id,
            'item_id' => $item->id,
            'value' => 100.00,
            'pickup_date' => now()->toDateString(),
            'return_date' => now()->addDays(3)->toDateString(),
        ]);

    $item->refresh();

    expect($item->quantity_available)->toBe(0)
        ->and($item->status)->toBe('alugado');
});

it('increases item quantity when marking rental as returned', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 3,
    ]);

    $rental = Rental::factory()->create([
        'item_id' => $item->id,
        'returned_at' => null,
    ]);

    actingAs($user)
        ->patch(route('return.rental', $rental))
        ->assertRedirect(route('rentals.index'));

    $item->refresh();

    expect($item->quantity_available)->toBe(4);
});

it('changes item status to disponivel when returning item', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 0,
        'status' => 'alugado',
    ]);

    $rental = Rental::factory()->create([
        'item_id' => $item->id,
        'returned_at' => null,
    ]);

    actingAs($user)
        ->patch(route('return.rental', $rental));

    $item->refresh();

    expect($item->quantity_available)->toBe(1)
        ->and($item->status)->toBe('disponivel');
});

it('restores item quantity when deleting unreturned rental', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 3,
    ]);

    $rental = Rental::factory()->create([
        'item_id' => $item->id,
        'returned_at' => null,
    ]);

    actingAs($user)
        ->delete(route('rentals.destroy', $rental));

    $item->refresh();

    expect($item->quantity_available)->toBe(4);
});

it('does not restore item quantity when deleting returned rental', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 3,
    ]);

    $rental = Rental::factory()->create([
        'item_id' => $item->id,
        'returned_at' => now(),
    ]);

    actingAs($user)
        ->delete(route('rentals.destroy', $rental));

    $item->refresh();

    expect($item->quantity_available)->toBe(3);
});

it('only shows items with available quantity on create page', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $availableItem = Item::factory()->create([
        'quantity_available' => 5,
        'status' => 'disponivel',
    ]);

    $unavailableItem = Item::factory()->create([
        'quantity_available' => 0,
        'status' => 'alugado',
    ]);

    actingAs($user)
        ->get(route('rentals.create'))
        ->assertInertia(fn ($page) => $page
            ->component('Rentals/Create')
            ->has('items', 1)
            ->where('items.0.id', $availableItem->id));
});

it('prevents creating rental when item has no available quantity', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $customer = Customer::factory()->create();
    $item = Item::factory()->create([
        'quantity_available' => 0,
        'status' => 'alugado',
    ]);

    actingAs($user)
        ->post(route('rentals.store'), [
            'customer_id' => $customer->id,
            'item_id' => $item->id,
            'value' => 100.00,
            'pickup_date' => now()->toDateString(),
            'return_date' => now()->addDays(3)->toDateString(),
        ])
        ->assertSessionHasErrors();
});

it('does not mark rental as returned twice', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $item = Item::factory()->create([
        'quantity_total' => 5,
        'quantity_available' => 3,
    ]);

    $rental = Rental::factory()->create([
        'item_id' => $item->id,
        'returned_at' => now()->subDay(),
    ]);

    actingAs($user)
        ->patch(route('return.rental', $rental));

    $item->refresh();

    // Quantity should remain the same
    expect($item->quantity_available)->toBe(3);
});
