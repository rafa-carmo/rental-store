<?php

use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Home Route
test('home page is accessible to guests', function () {
    $this->get(route('home'))
        ->assertSuccessful();
});

// Dashboard Routes
test('dashboard requires authentication', function () {
    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));
});

test('authenticated user can access dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertSuccessful();
});

// Item Types Routes
test('item-types index requires authentication', function () {
    $this->get(route('item-types.index'))
        ->assertRedirect(route('login'));
});

test('item-types create requires authentication', function () {
    $this->get(route('item-types.create'))
        ->assertRedirect(route('login'));
});

test('item-types store requires authentication', function () {
    $this->post(route('item-types.store'), [])
        ->assertRedirect(route('login'));
});

test('item-types edit requires authentication', function () {
    $itemType = ItemType::factory()->create();

    $this->get(route('item-types.edit', $itemType))
        ->assertRedirect(route('login'));
});

test('item-types update requires authentication', function () {
    $itemType = ItemType::factory()->create();

    $this->put(route('item-types.update', $itemType), [])
        ->assertRedirect(route('login'));
});

test('item-types destroy requires authentication', function () {
    $itemType = ItemType::factory()->create();

    $this->delete(route('item-types.destroy', $itemType))
        ->assertRedirect(route('login'));
});

test('authenticated user can access item-types index', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('item-types.index'))
        ->assertSuccessful();
});

test('authenticated user can access item-types create', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('item-types.create'))
        ->assertSuccessful();
});

test('authenticated user can store item-type', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('item-types.store'), [
            'name' => 'Test Type',
            'description' => 'Test Description',
            'is_active' => 'on',
        ])
        ->assertRedirect(route('item-types.index'));
});

test('authenticated user can access item-types edit', function () {
    $user = User::factory()->create();
    $itemType = ItemType::factory()->create();

    $this->actingAs($user)
        ->get(route('item-types.edit', $itemType))
        ->assertSuccessful();
});

test('authenticated user can update item-type', function () {
    $user = User::factory()->create();
    $itemType = ItemType::factory()->create();

    $this->actingAs($user)
        ->put(route('item-types.update', $itemType), [
            'name' => 'Updated Type',
            'description' => 'Updated Description',
            'is_active' => 'on',
        ])
        ->assertRedirect(route('item-types.index'));
});

test('authenticated user can destroy item-type', function () {
    $user = User::factory()->create();
    $itemType = ItemType::factory()->create();

    $this->actingAs($user)
        ->delete(route('item-types.destroy', $itemType))
        ->assertRedirect(route('item-types.index'));
});

// Items Routes
test('items index requires authentication', function () {
    $this->get(route('items.index'))
        ->assertRedirect(route('login'));
});

test('items create requires authentication', function () {
    $this->get(route('items.create'))
        ->assertRedirect(route('login'));
});

test('items store requires authentication', function () {
    $this->post(route('items.store'), [])
        ->assertRedirect(route('login'));
});

test('items edit requires authentication', function () {
    $item = Item::factory()->create();

    $this->get(route('items.edit', $item))
        ->assertRedirect(route('login'));
});

test('items update requires authentication', function () {
    $item = Item::factory()->create();

    $this->put(route('items.update', $item), [])
        ->assertRedirect(route('login'));
});

test('items destroy requires authentication', function () {
    $item = Item::factory()->create();

    $this->delete(route('items.destroy', $item))
        ->assertRedirect(route('login'));
});

test('authenticated user can access items index', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('items.index'))
        ->assertSuccessful();
});

test('authenticated user can access items create', function () {
    $user = User::factory()->create();
    ItemType::factory()->active()->create();

    $this->actingAs($user)
        ->get(route('items.create'))
        ->assertSuccessful();
});

test('authenticated user can store item', function () {
    $user = User::factory()->create();
    $itemType = ItemType::factory()->create();

    $this->actingAs($user)
        ->post(route('items.store'), [
            'name' => 'Test Item',
            'item_type_id' => $itemType->id,
            'quantity_total' => 5,
            'quantity_available' => 5,
            'status' => 'disponivel',
        ])
        ->assertRedirect(route('items.index'));
});

test('authenticated user can access items edit', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create();
    ItemType::factory()->active()->create();

    $this->actingAs($user)
        ->get(route('items.edit', $item))
        ->assertSuccessful();
});

test('authenticated user can update item', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create();

    $this->actingAs($user)
        ->put(route('items.update', $item), [
            'name' => 'Updated Item',
            'item_type_id' => $item->item_type_id,
            'quantity_total' => 10,
            'quantity_available' => 8,
            'status' => 'disponivel',
        ])
        ->assertRedirect(route('items.index'));
});

test('authenticated user can destroy item', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create();

    $this->actingAs($user)
        ->delete(route('items.destroy', $item))
        ->assertRedirect(route('items.index'));
});

// Customers Routes
test('customers index requires authentication', function () {
    $this->get(route('customers.index'))
        ->assertRedirect(route('login'));
});

test('customers create requires authentication', function () {
    $this->get(route('customers.create'))
        ->assertRedirect(route('login'));
});

test('customers store requires authentication', function () {
    $this->post(route('customers.store'), [])
        ->assertRedirect(route('login'));
});

test('customers edit requires authentication', function () {
    $customer = Customer::factory()->create();

    $this->get(route('customers.edit', $customer))
        ->assertRedirect(route('login'));
});

test('customers update requires authentication', function () {
    $customer = Customer::factory()->create();

    $this->put(route('customers.update', $customer), [])
        ->assertRedirect(route('login'));
});

test('customers destroy requires authentication', function () {
    $customer = Customer::factory()->create();

    $this->delete(route('customers.destroy', $customer))
        ->assertRedirect(route('login'));
});

test('authenticated user can access customers index', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('customers.index'))
        ->assertSuccessful();
});

test('authenticated user can access customers create', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('customers.create'))
        ->assertSuccessful();
});

test('authenticated user can store customer', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('customers.store'), [
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
        ])
        ->assertRedirect(route('customers.index'));
});

test('authenticated user can access customers edit', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();

    $this->actingAs($user)
        ->get(route('customers.edit', $customer))
        ->assertSuccessful();
});

test('authenticated user can update customer', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();

    $this->actingAs($user)
        ->put(route('customers.update', $customer), [
            'name' => 'Updated Customer',
            'email' => 'updated@test.com',
            'phone' => '9876543210',
            'address' => 'Updated Address',
        ])
        ->assertRedirect(route('customers.index'));
});

test('authenticated user can destroy customer', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();

    $this->actingAs($user)
        ->delete(route('customers.destroy', $customer))
        ->assertRedirect(route('customers.index'));
});

// Admin Users Routes
test('admin-users index requires authentication', function () {
    $this->get(route('admin-users.index'))
        ->assertRedirect(route('login'));
});

test('admin-users create requires authentication', function () {
    $this->get(route('admin-users.create'))
        ->assertRedirect(route('login'));
});

test('admin-users store requires authentication', function () {
    $this->post(route('admin-users.store'), [])
        ->assertRedirect(route('login'));
});

test('admin-users edit requires authentication', function () {
    $adminUser = User::factory()->create(['role' => 'admin']);

    $this->get(route('admin-users.edit', $adminUser))
        ->assertRedirect(route('login'));
});

test('admin-users update requires authentication', function () {
    $adminUser = User::factory()->create(['role' => 'admin']);

    $this->put(route('admin-users.update', $adminUser), [])
        ->assertRedirect(route('login'));
});

test('admin-users destroy requires authentication', function () {
    $adminUser = User::factory()->create(['role' => 'admin']);

    $this->delete(route('admin-users.destroy', $adminUser))
        ->assertRedirect(route('login'));
});

test('authenticated user can access admin-users index', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
        ->get(route('admin-users.index'))
        ->assertSuccessful();
});

test('authenticated user can access admin-users create', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
        ->get(route('admin-users.create'))
        ->assertSuccessful();
});

test('authenticated user can store admin-user', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
        ->post(route('admin-users.store'), [
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ])
        ->assertRedirect(route('admin-users.index'));
});

test('authenticated user can access admin-users edit', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $adminUser = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
        ->get(route('admin-users.edit', $adminUser))
        ->assertSuccessful();
});

test('authenticated user can update admin-user', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $adminUser = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
        ->put(route('admin-users.update', $adminUser), [
            'name' => 'Updated Admin',
            'email' => 'updatedadmin@test.com',
            'role' => 'admin',
        ])
        ->assertRedirect(route('admin-users.index'));
});

test('authenticated user can destroy admin-user', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $adminUser = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
        ->delete(route('admin-users.destroy', $adminUser))
        ->assertRedirect(route('admin-users.index'));
});

// Rentals Routes
test('rentals index requires authentication', function () {
    $this->get(route('rentals.index'))
        ->assertRedirect(route('login'));
});

test('rentals create requires authentication', function () {
    $this->get(route('rentals.create'))
        ->assertRedirect(route('login'));
});

test('rentals store requires authentication', function () {
    $this->post(route('rentals.store'), [])
        ->assertRedirect(route('login'));
});

test('rentals edit requires authentication', function () {
    $rental = Rental::factory()->create();

    $this->get(route('rentals.edit', $rental))
        ->assertRedirect(route('login'));
});

test('rentals update requires authentication', function () {
    $rental = Rental::factory()->create();

    $this->put(route('rentals.update', $rental), [])
        ->assertRedirect(route('login'));
});

test('rentals destroy requires authentication', function () {
    $rental = Rental::factory()->create();

    $this->delete(route('rentals.destroy', $rental))
        ->assertRedirect(route('login'));
});

test('rentals return requires authentication', function () {
    $rental = Rental::factory()->create();

    $this->patch(route('return.rental', $rental))
        ->assertRedirect(route('login'));
});

test('authenticated user can access rentals index', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('rentals.index'))
        ->assertSuccessful();
});

test('authenticated user can access rentals create', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('rentals.create'))
        ->assertSuccessful();
});

test('authenticated user can store rental', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();
    $item = Item::factory()->create([
        'quantity_available' => 5,
    ]);

    $this->actingAs($user)
        ->post(route('rentals.store'), [
            'customer_id' => $customer->id,
            'item_id' => $item->id,
            'value' => 100.00,
            'pickup_date' => now()->toDateString(),
            'return_date' => now()->addDays(3)->toDateString(),
        ])
        ->assertRedirect(route('rentals.index'));
});

test('authenticated user can access rentals edit', function () {
    $user = User::factory()->create();
    $rental = Rental::factory()->create();

    $this->actingAs($user)
        ->get(route('rentals.edit', $rental))
        ->assertSuccessful();
});

test('authenticated user can update rental', function () {
    $user = User::factory()->create();
    $rental = Rental::factory()->create();

    $this->actingAs($user)
        ->put(route('rentals.update', $rental), [
            'customer_id' => $rental->customer_id,
            'item_id' => $rental->item_id,
            'value' => 150.00,
            'pickup_date' => $rental->pickup_date,
            'return_date' => $rental->return_date,
        ])
        ->assertRedirect(route('rentals.index'));
});

test('authenticated user can destroy rental', function () {
    $user = User::factory()->create();
    $rental = Rental::factory()->create(['returned_at' => now()]);

    $this->actingAs($user)
        ->delete(route('rentals.destroy', $rental))
        ->assertRedirect(route('rentals.index'));
});

test('authenticated user can mark rental as returned', function () {
    $user = User::factory()->create();
    $rental = Rental::factory()->create(['returned_at' => null]);

    $this->actingAs($user)
        ->patch(route('return.rental', $rental))
        ->assertRedirect(route('rentals.index'));
});

// Settings Routes
test('settings profile edit requires authentication', function () {
    $this->get(route('profile.edit'))
        ->assertRedirect(route('login'));
});

test('settings password edit requires authentication', function () {
    $this->get(route('user-password.edit'))
        ->assertRedirect(route('login'));
});

test('settings password update requires authentication', function () {
    $this->put(route('user-password.update'), [])
        ->assertRedirect(route('login'));
});

test('authenticated user can access profile edit', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertSuccessful();
});

test('authenticated user can access password edit', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('user-password.edit'))
        ->assertSuccessful();
});

test('authenticated user can update password', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('user-password.update'), [
            'current_password' => 'password',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])
        ->assertRedirect();
});

// Auth Routes - These should be accessible to guests
test('login page is accessible to guests', function () {
    $this->get(route('login'))
        ->assertSuccessful();
});

test('register page is accessible to guests', function () {
    $this->get(route('register'))
        ->assertSuccessful();
});

test('forgot password page is accessible to guests', function () {
    $this->get(route('password.request'))
        ->assertSuccessful();
});

test('authenticated users are redirected from login', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('login'))
        ->assertRedirect(route('dashboard'));
});

test('authenticated users are redirected from register', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('register'))
        ->assertRedirect(route('dashboard'));
});
