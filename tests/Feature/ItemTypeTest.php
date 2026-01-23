<?php

use App\Models\ItemType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->group('item-types');

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can display item types index page', function () {
    $itemTypes = ItemType::factory()->count(3)->create();

    $this->get(route('item-types.index'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('ItemTypes/Index')
            ->has('itemTypes', 3)
        );
});

test('can display create item type page', function () {
    $this->get(route('item-types.create'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('ItemTypes/Create')
        );
});

test('can store a new item type', function () {
    $data = [
        'name' => 'Ferramentas',
        'description' => 'Ferramentas para construção',
        'is_active' => true,
    ];

    $this->post(route('item-types.store'), $data)
        ->assertRedirect(route('item-types.index'));

    $this->assertDatabaseHas('item_types', $data);
});

test('requires name when storing item type', function () {
    $this->post(route('item-types.store'), [
        'description' => 'Test description',
        'is_active' => true,
    ])->assertInvalid(['name']);
});


test('can display edit item type page', function () {
    $itemType = ItemType::factory()->create();

    $this->get(route('item-types.edit', $itemType))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('ItemTypes/Edit')
            ->has('itemType')
            ->where('itemType.id', $itemType->id)
        );
});

test('can update an item type', function () {
    $itemType = ItemType::factory()->create();

    $data = [
        'name' => 'Updated Name',
        'description' => 'Updated description',

    ];

    $this->put(route('item-types.update', $itemType), $data)
        ->assertRedirect(route('item-types.index'));

    $this->assertDatabaseHas('item_types', [
        'id' => $itemType->id,
        ...$data,
    ]);
});

test('requires name when updating item type', function () {
    $itemType = ItemType::factory()->create();

    $this->put(route('item-types.update', $itemType), [
        'description' => 'Test description',
        'is_active' => true,
    ])->assertInvalid(['name']);
});

test('can delete an item type', function () {
    $itemType = ItemType::factory()->create();

    $this->delete(route('item-types.destroy', $itemType))
        ->assertRedirect(route('item-types.index'));

    $this->assertDatabaseMissing('item_types', [
        'id' => $itemType->id,
    ]);
});

test('description can be nullable', function () {
    $data = [
        'name' => 'Test Type',
        'description' => null,
        'is_active' => true,
    ];

    $this->post(route('item-types.store'), $data)
        ->assertRedirect(route('item-types.index'));

    $this->assertDatabaseHas('item_types', $data);
});

test('can create item type with factory active state', function () {
    $itemType = ItemType::factory()->active()->create();

    expect($itemType->is_active)->toBeTrue();
});

test('can create item type with factory inactive state', function () {
    $itemType = ItemType::factory()->inactive()->create();

    expect($itemType->is_active)->toBeFalse();
});
