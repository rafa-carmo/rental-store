<?php

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->group('companies');

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can display companies index page', function () {
    $companies = Company::factory()->count(3)->create();

    $this->get(route('companies.index'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Companies/Index')
            ->has('companies', 3)
        );
});

test('can display create company page', function () {
    $this->get(route('companies.create'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Companies/Create')
        );
});

test('can store a new company with all fields', function () {
    $data = [
        'name' => 'Tech Solutions LTDA',
        'email' => 'contato@techsolutions.com',
        'phone' => '(11) 3456-7890',
        'cep' => '01310-100',
        'street' => 'Avenida Paulista',
        'number' => '1578',
        'city' => 'São Paulo',
        'state' => 'SP',
        'country' => 'Brasil',
    ];

    $this->post(route('companies.store'), $data)
        ->assertRedirect(route('companies.index'));

    $this->assertDatabaseHas('companies', $data);
});

test('requires all fields when storing company', function () {
    $this->post(route('companies.store'), [])
        ->assertInvalid(['name', 'email', 'phone', 'cep', 'street', 'number', 'city', 'state', 'country']);
});

test('requires name when storing company', function () {
    $this->post(route('companies.store'), [
        'email' => 'test@company.com',
        'phone' => '(11) 98765-4321',
        'cep' => '01310-100',
        'street' => 'Rua Teste',
        'number' => '123',
        'city' => 'São Paulo',
        'state' => 'SP',
        'country' => 'Brasil',
    ])->assertInvalid(['name']);
});

test('validates email format when storing company', function () {
    $this->post(route('companies.store'), [
        'name' => 'Test Company',
        'email' => 'invalid-email',
        'phone' => '(11) 98765-4321',
        'cep' => '01310-100',
        'street' => 'Rua Teste',
        'number' => '123',
        'city' => 'São Paulo',
        'state' => 'SP',
        'country' => 'Brasil',
    ])->assertInvalid(['email']);
});

test('can display edit company page', function () {
    $company = Company::factory()->create();

    $this->get(route('companies.edit', $company))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Companies/Edit')
            ->has('company')
            ->where('company.id', $company->id)
        );
});

test('can update a company', function () {
    $company = Company::factory()->create();

    $data = [
        'name' => 'Updated Company Name',
        'email' => 'updated@company.com',
        'phone' => '(21) 99999-8888',
        'cep' => '20040-020',
        'street' => 'Rua Atualizada',
        'number' => '100',
        'city' => 'Rio de Janeiro',
        'state' => 'RJ',
        'country' => 'Brasil',
    ];

    $this->put(route('companies.update', $company), $data)
        ->assertRedirect(route('companies.index'));

    $this->assertDatabaseHas('companies', [
        'id' => $company->id,
        ...$data,
    ]);
});

test('requires all fields when updating company', function () {
    $company = Company::factory()->create();

    $this->put(route('companies.update', $company), [])
        ->assertInvalid(['name', 'email', 'phone', 'cep', 'street', 'number', 'city', 'state', 'country']);
});

test('validates email format when updating company', function () {
    $company = Company::factory()->create();

    $this->put(route('companies.update', $company), [
        'name' => 'Test Company',
        'email' => 'invalid-email',
        'phone' => '(11) 98765-4321',
        'cep' => '01310-100',
        'street' => 'Rua Teste',
        'number' => '123',
        'city' => 'São Paulo',
        'state' => 'SP',
        'country' => 'Brasil',
    ])->assertInvalid(['email']);
});

test('can delete a company', function () {
    $company = Company::factory()->create();

    $this->delete(route('companies.destroy', $company))
        ->assertRedirect(route('companies.index'));

    $this->assertDatabaseMissing('companies', [
        'id' => $company->id,
    ]);
});
