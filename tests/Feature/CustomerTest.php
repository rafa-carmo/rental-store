<?php

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->group('customers');

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can display customers index page', function () {
    $customers = Customer::factory()->count(3)->create();

    $this->get(route('customers.index'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Customers/Index')
            ->has('customers', 3)
        );
});

test('can display create customer page', function () {
    $this->get(route('customers.create'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Customers/Create')
        );
});

test('can store a new customer with all fields', function () {
    $data = [
        'name' => 'João Silva',
        'phone' => '(11) 98765-4321',
        'email' => 'joao@email.com',
        'cep' => '01310-100',
        'street' => 'Avenida Paulista',
        'number' => '1578',
        'complement' => 'Apto 101',
        'state' => 'SP',
        'city' => 'São Paulo',
    ];

    $this->post(route('customers.store'), $data)
        ->assertRedirect(route('customers.index'));

    $this->assertDatabaseHas('customers', $data);
});

test('can store a new customer with only required fields', function () {
    $data = [
        'name' => 'Maria Santos',
    ];

    $this->post(route('customers.store'), $data)
        ->assertRedirect(route('customers.index'));

    $this->assertDatabaseHas('customers', [
        'name' => 'Maria Santos',
        'phone' => null,
        'email' => null,
        'cep' => null,
        'street' => null,
        'number' => null,
        'complement' => null,
        'state' => null,
        'city' => null,
    ]);
});

test('requires name when storing customer', function () {
    $this->post(route('customers.store'), [
        'phone' => '(11) 98765-4321',
        'email' => 'test@email.com',
    ])->assertInvalid(['name']);
});

test('validates email format when storing customer', function () {
    $this->post(route('customers.store'), [
        'name' => 'Test Name',
        'email' => 'invalid-email',
    ])->assertInvalid(['email']);
});

test('can display edit customer page', function () {
    $customer = Customer::factory()->create();

    $this->get(route('customers.edit', $customer))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Customers/Edit')
            ->has('customer')
            ->where('customer.id', $customer->id)
        );
});

test('can update a customer', function () {
    $customer = Customer::factory()->create();

    $data = [
        'name' => 'Updated Name',
        'phone' => '(21) 99999-8888',
        'email' => 'updated@email.com',
        'cep' => '20040-020',
        'street' => 'Rua Atualizada',
        'number' => '100',
        'complement' => 'Casa',
        'state' => 'RJ',
        'city' => 'Rio de Janeiro',
    ];

    $this->put(route('customers.update', $customer), $data)
        ->assertRedirect(route('customers.index'));

    $this->assertDatabaseHas('customers', [
        'id' => $customer->id,
        ...$data,
    ]);
});

test('requires name when updating customer', function () {
    $customer = Customer::factory()->create();

    $this->put(route('customers.update', $customer), [
        'phone' => '(11) 98765-4321',
        'email' => 'test@email.com',
    ])->assertInvalid(['name']);
});

test('validates email format when updating customer', function () {
    $customer = Customer::factory()->create();

    $this->put(route('customers.update', $customer), [
        'name' => 'Test Name',
        'email' => 'invalid-email',
    ])->assertInvalid(['email']);
});

test('can delete a customer', function () {
    $customer = Customer::factory()->create();

    $this->delete(route('customers.destroy', $customer))
        ->assertRedirect(route('customers.index'));

    $this->assertDatabaseMissing('customers', [
        'id' => $customer->id,
    ]);
});

test('can create customer using factory', function () {
    $customer = Customer::factory()->create();

    expect($customer)->toBeInstanceOf(Customer::class)
        ->and($customer->name)->not->toBeEmpty();
});

test('can create customer with nullable address fields', function () {
    $customer = Customer::factory()->create([
        'cep' => null,
        'street' => null,
        'number' => null,
        'complement' => null,
        'state' => null,
        'city' => null,
    ]);

    expect($customer->cep)->toBeNull()
        ->and($customer->street)->toBeNull()
        ->and($customer->number)->toBeNull()
        ->and($customer->complement)->toBeNull()
        ->and($customer->state)->toBeNull()
        ->and($customer->city)->toBeNull();
});
