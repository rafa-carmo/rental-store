<?php

use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->group('rentals');

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can display rentals index page', function () {
    $customer = Customer::factory()->create();
    $itemType = ItemType::factory()->create();
    $item = Item::factory()->for($itemType)->create();
    $rental = Rental::factory()->for($customer)->for($item)->create();

    $this->get(route('rentals.index'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Rentals/Index')
            ->has('rentals', 1)
        );
});

test('can display create rental page', function () {
    Customer::factory()->create();
    Item::factory()->create();

    $this->get(route('rentals.create'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Rentals/Create')
            ->has('customers')
            ->has('items')
        );
});

test('can store a new rental', function () {
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();

    $data = [
        'customer_id' => $customer->id,
        'item_id' => $item->id,
        'value' => 150.00,
        'pickup_date' => now()->format('Y-m-d'),
        'return_date' => now()->addDays(7)->format('Y-m-d'),
    ];

    $this->post(route('rentals.store'), $data)
        ->assertRedirect(route('rentals.index'));

    $this->assertDatabaseHas('rentals', [
        'customer_id' => $customer->id,
        'item_id' => $item->id,
        'value' => 150.00,
    ]);
});

test('requires customer_id when storing rental', function () {
    $item = Item::factory()->create();

    $this->post(route('rentals.store'), [
        'item_id' => $item->id,
        'value' => 150.00,
        'pickup_date' => now()->format('Y-m-d'),
        'return_date' => now()->addDays(7)->format('Y-m-d'),
    ])->assertInvalid(['customer_id']);
});

test('requires item_id when storing rental', function () {
    $customer = Customer::factory()->create();

    $this->post(route('rentals.store'), [
        'customer_id' => $customer->id,
        'value' => 150.00,
        'pickup_date' => now()->format('Y-m-d'),
        'return_date' => now()->addDays(7)->format('Y-m-d'),
    ])->assertInvalid(['item_id']);
});

test('requires value when storing rental', function () {
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();

    $this->post(route('rentals.store'), [
        'customer_id' => $customer->id,
        'item_id' => $item->id,
        'pickup_date' => now()->format('Y-m-d'),
        'return_date' => now()->addDays(7)->format('Y-m-d'),
    ])->assertInvalid(['value']);
});

test('validates return_date is after or equal to pickup_date', function () {
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();

    $this->post(route('rentals.store'), [
        'customer_id' => $customer->id,
        'item_id' => $item->id,
        'value' => 150.00,
        'pickup_date' => now()->format('Y-m-d'),
        'return_date' => now()->subDays(1)->format('Y-m-d'),
    ])->assertInvalid(['return_date']);
});

test('can display edit rental page', function () {
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();
    $rental = Rental::factory()->for($customer)->for($item)->create();

    $this->get(route('rentals.edit', $rental))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Rentals/Edit')
            ->has('rental')
            ->has('customers')
            ->has('items')
            ->where('rental.id', $rental->id)
        );
});

test('can update a rental', function () {
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();
    $rental = Rental::factory()->for($customer)->for($item)->create();

    $newCustomer = Customer::factory()->create();
    $newItem = Item::factory()->create();

    $data = [
        'customer_id' => $newCustomer->id,
        'item_id' => $newItem->id,
        'value' => 250.00,
        'pickup_date' => now()->addDays(1)->format('Y-m-d'),
        'return_date' => now()->addDays(10)->format('Y-m-d'),
    ];

    $this->put(route('rentals.update', $rental), $data)
        ->assertRedirect(route('rentals.index'));

    $this->assertDatabaseHas('rentals', [
        'id' => $rental->id,
        'customer_id' => $newCustomer->id,
        'item_id' => $newItem->id,
        'value' => 250.00,
    ]);
});

test('can delete a rental', function () {
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();
    $rental = Rental::factory()->for($customer)->for($item)->create();

    $this->delete(route('rentals.destroy', $rental))
        ->assertRedirect(route('rentals.index'));

    $this->assertDatabaseMissing('rentals', [
        'id' => $rental->id,
    ]);
});

test('can create rental using factory', function () {
    $rental = Rental::factory()->create();

    expect($rental)->toBeInstanceOf(Rental::class)
        ->and($rental->customer)->toBeInstanceOf(Customer::class)
        ->and($rental->item)->toBeInstanceOf(Item::class)
        ->and($rental->value)->toBeGreaterThan(0);
});

test('rental belongs to customer', function () {
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();
    $rental = Rental::factory()->for($customer)->for($item)->create();

    expect($rental->customer->id)->toBe($customer->id);
});

test('rental belongs to item', function () {
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();
    $rental = Rental::factory()->for($customer)->for($item)->create();

    expect($rental->item->id)->toBe($item->id);
});

test('can mark rental as returned', function () {
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();
    $rental = Rental::factory()->for($customer)->for($item)->create([
        'returned_at' => null,
    ]);

    expect($rental->returned_at)->toBeNull();

    $this->patch(route('rentals.return', $rental))
        ->assertRedirect(route('rentals.index'));

    $rental->refresh();

    expect($rental->returned_at)->not->toBeNull();
});
