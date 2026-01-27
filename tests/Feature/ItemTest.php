<?php

use App\Models\Item;
use App\Models\ItemType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class)->group('items');

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can display items index page', function () {
    $itemType = ItemType::factory()->create();
    $items = Item::factory()->count(3)->for($itemType)->create();

    $this->get(route('items.index'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Items/Index')
            ->has('items', 3)
        );
});

test('can display create item page', function () {
    ItemType::factory()->active()->create();

    $this->get(route('items.create'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Items/Create')
            ->has('itemTypes')
        );
});

test('can store a new item', function () {
    $itemType = ItemType::factory()->create();

    $data = [
        'name' => 'Furadeira Elétrica',
        'description' => 'Furadeira de impacto 800W',
        'item_type_id' => $itemType->id,
        'quantity_total' => 5,
        'quantity_available' => 5,
        'status' => 'disponivel',
    ];

    $this->post(route('items.store'), $data)
        ->assertRedirect(route('items.index'));

    $this->assertDatabaseHas('items', $data);
});

test('can store item with image', function () {
    Storage::fake('public');
    $itemType = ItemType::factory()->create();

    $data = [
        'name' => 'Furadeira Elétrica',
        'description' => 'Furadeira de impacto 800W',
        'image' => UploadedFile::fake()->image('furadeira.jpg'),
        'item_type_id' => $itemType->id,
        'quantity_total' => 3,
        'quantity_available' => 3,
        'status' => 'disponivel',
    ];

    $this->post(route('items.store'), $data)
        ->assertRedirect(route('items.index'));

    $item = Item::first();
    expect($item->image)->not->toBeNull();
    Storage::disk('public')->assertExists($item->image);
});

test('requires name when storing item', function () {
    $itemType = ItemType::factory()->create();

    $this->post(route('items.store'), [
        'description' => 'Test description',
        'item_type_id' => $itemType->id,
        'status' => 'disponivel',
    ])->assertInvalid(['name']);
});

test('requires item_type_id when storing item', function () {
    $this->post(route('items.store'), [
        'name' => 'Test Item',
        'description' => 'Test description',
        'quantity_total' => 1,
        'quantity_available' => 1,
        'status' => 'disponivel',
    ])->assertInvalid(['item_type_id']);
});

test('requires status when storing item', function () {
    $itemType = ItemType::factory()->create();

    $this->post(route('items.store'), [
        'name' => 'Test Item',
        'description' => 'Test description',
        'item_type_id' => $itemType->id,
        'quantity_total' => 1,
        'quantity_available' => 1,
    ])->assertInvalid(['status']);
});

test('validates status values', function () {
    $itemType = ItemType::factory()->create();

    $this->post(route('items.store'), [
        'name' => 'Test Item',
        'item_type_id' => $itemType->id,
        'quantity_total' => 1,
        'quantity_available' => 1,
        'status' => 'invalid_status',
    ])->assertInvalid(['status']);
});

test('can display edit item page', function () {
    $item = Item::factory()->for(ItemType::factory())->create();
    ItemType::factory()->active()->create();

    $this->get(route('items.edit', $item))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Items/Edit')
            ->has('item')
            ->has('itemTypes')
            ->where('item.id', $item->id)
        );
});

test('can update an item', function () {
    $item = Item::factory()->for(ItemType::factory())->create();
    $newItemType = ItemType::factory()->create();

    $data = [
        'name' => 'Updated Name',
        'description' => 'Updated description',
        'item_type_id' => $newItemType->id,
        'quantity_total' => 10,
        'quantity_available' => 8,
        'status' => 'alugado',
    ];

    $this->put(route('items.update', $item), $data)
        ->assertRedirect(route('items.index'));

    $this->assertDatabaseHas('items', [
        'id' => $item->id,
        ...$data,
    ]);
});

test('can update item with new image', function () {
    Storage::fake('public');
    $item = Item::factory()->for(ItemType::factory())->create([
        'image' => 'items/old-image.jpg',
    ]);

    $data = [
        'name' => $item->name,
        'description' => $item->description,
        'image' => UploadedFile::fake()->image('new-image.jpg'),
        'item_type_id' => $item->item_type_id,
        'quantity_total' => $item->quantity_total,
        'quantity_available' => $item->quantity_available,
        'status' => $item->status,
    ];

    $this->put(route('items.update', $item), $data)
        ->assertRedirect(route('items.index'));

    $item->refresh();
    expect($item->image)->not->toBe('items/old-image.jpg');
    Storage::disk('public')->assertExists($item->image);
});

test('can delete an item', function () {
    $item = Item::factory()->for(ItemType::factory())->create();

    $this->delete(route('items.destroy', $item))
        ->assertRedirect(route('items.index'));

    $this->assertDatabaseMissing('items', [
        'id' => $item->id,
    ]);
});

test('deletes image when deleting item', function () {
    Storage::fake('public');
    $item = Item::factory()->for(ItemType::factory())->create();
    $image = UploadedFile::fake()->image('test.jpg');
    $path = $image->store('items', 'public');
    $item->update(['image' => $path]);

    Storage::disk('public')->assertExists($path);

    $this->delete(route('items.destroy', $item));

    Storage::disk('public')->assertMissing($path);
});

test('description can be nullable', function () {
    $itemType = ItemType::factory()->create();

    $data = [
        'name' => 'Test Item',
        'description' => null,
        'item_type_id' => $itemType->id,
        'quantity_total' => 1,
        'quantity_available' => 1,
        'status' => 'disponivel',
    ];

    $this->post(route('items.store'), $data)
        ->assertRedirect(route('items.index'));

    $this->assertDatabaseHas('items', $data);
});

test('can create item with factory disponivel state', function () {
    $item = Item::factory()->disponivel()->create();

    expect($item->status)->toBe('disponivel');
});

test('can create item with factory alugado state', function () {
    $item = Item::factory()->alugado()->create();

    expect($item->status)->toBe('alugado');
});

test('can create item with factory indisponivel state', function () {
    $item = Item::factory()->indisponivel()->create();

    expect($item->status)->toBe('indisponivel');
});

test('item belongs to item type', function () {
    $itemType = ItemType::factory()->create();
    $item = Item::factory()->for($itemType)->create();

    expect($item->itemType)->toBeInstanceOf(ItemType::class);
    expect($item->itemType->id)->toBe($itemType->id);
});

test('requires quantity_total when storing item', function () {
    $itemType = ItemType::factory()->create();

    $this->post(route('items.store'), [
        'name' => 'Test Item',
        'item_type_id' => $itemType->id,
        'quantity_available' => 1,
        'status' => 'disponivel',
    ])->assertInvalid(['quantity_total']);
});

test('requires quantity_available when storing item', function () {
    $itemType = ItemType::factory()->create();

    $this->post(route('items.store'), [
        'name' => 'Test Item',
        'item_type_id' => $itemType->id,
        'quantity_total' => 5,
        'status' => 'disponivel',
    ])->assertInvalid(['quantity_available']);
});

test('validates quantity_total must be at least 1', function () {
    $itemType = ItemType::factory()->create();

    $this->post(route('items.store'), [
        'name' => 'Test Item',
        'item_type_id' => $itemType->id,
        'quantity_total' => 0,
        'quantity_available' => 0,
        'status' => 'disponivel',
    ])->assertInvalid(['quantity_total']);
});

test('validates quantity_available cannot be negative', function () {
    $itemType = ItemType::factory()->create();

    $this->post(route('items.store'), [
        'name' => 'Test Item',
        'item_type_id' => $itemType->id,
        'quantity_total' => 5,
        'quantity_available' => -1,
        'status' => 'disponivel',
    ])->assertInvalid(['quantity_available']);
});

test('validates quantity_available cannot exceed quantity_total', function () {
    $itemType = ItemType::factory()->create();

    $this->post(route('items.store'), [
        'name' => 'Test Item',
        'item_type_id' => $itemType->id,
        'quantity_total' => 5,
        'quantity_available' => 10,
        'status' => 'disponivel',
    ])->assertInvalid(['quantity_available']);
});

test('can create item with quantity_available equal to quantity_total', function () {
    $itemType = ItemType::factory()->create();

    $data = [
        'name' => 'Test Item',
        'item_type_id' => $itemType->id,
        'quantity_total' => 5,
        'quantity_available' => 5,
        'status' => 'disponivel',
    ];

    $this->post(route('items.store'), $data)
        ->assertRedirect(route('items.index'));

    $this->assertDatabaseHas('items', $data);
});

test('can create item with quantity_available less than quantity_total', function () {
    $itemType = ItemType::factory()->create();

    $data = [
        'name' => 'Test Item',
        'item_type_id' => $itemType->id,
        'quantity_total' => 5,
        'quantity_available' => 3,
        'status' => 'disponivel',
    ];

    $this->post(route('items.store'), $data)
        ->assertRedirect(route('items.index'));

    $this->assertDatabaseHas('items', $data);
});
