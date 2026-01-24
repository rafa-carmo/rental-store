<?php

use App\Models\Customer;
use App\Models\Item;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->group('dashboard');

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('guests are redirected to login page', function () {
    auth()->logout();

    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

test('authenticated users can visit dashboard', function () {
    $this->get(route('dashboard'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('Dashboard/Index')
            ->has('stats')
        );
});

test('dashboard shows correct items count for period', function () {
    // Items created within last month
    Item::factory()->count(3)->create(['created_at' => now()->subDays(15)]);

    // Items created outside period
    Item::factory()->count(2)->create(['created_at' => now()->subMonths(2)]);

    $response = $this->get(route('dashboard', ['period' => '1']));

    $response->assertInertia(fn ($page) => $page
        ->where('stats.itemsCount', 3)
    );
});

test('dashboard shows correct customers count for period', function () {
    // Customers created within last 3 months
    Customer::factory()->count(5)->create(['created_at' => now()->subMonths(2)]);

    // Customers created outside period
    Customer::factory()->count(3)->create(['created_at' => now()->subMonths(7)]);

    $response = $this->get(route('dashboard', ['period' => '3']));

    $response->assertInertia(fn ($page) => $page
        ->where('stats.customersCount', 5)
    );
});

test('dashboard shows correct rentals count for period', function () {
    // Rentals within last 6 months
    Rental::factory()->count(4)->create(['pickup_date' => now()->subMonths(3)]);

    // Rentals outside period
    Rental::factory()->count(2)->create(['pickup_date' => now()->subMonths(8)]);

    $response = $this->get(route('dashboard', ['period' => '6']));

    $response->assertInertia(fn ($page) => $page
        ->where('stats.rentalsCount', 4)
    );
});

test('dashboard shows correct returns count for period', function () {
    // Returns within last year
    Rental::factory()->count(3)->create([
        'pickup_date' => now()->subMonths(6),
        'returned_at' => now()->subMonths(5),
    ]);

    // Returns outside period
    Rental::factory()->count(2)->create([
        'pickup_date' => now()->subMonths(15),
        'returned_at' => now()->subMonths(14),
    ]);

    // Rentals not yet returned
    Rental::factory()->count(2)->create([
        'pickup_date' => now()->subMonths(2),
        'returned_at' => null,
    ]);

    $response = $this->get(route('dashboard', ['period' => '12']));

    $response->assertInertia(fn ($page) => $page
        ->where('stats.returnsCount', 3)
    );
});

test('dashboard calculates total revenue correctly', function () {
    // Rentals within period
    Rental::factory()->create([
        'value' => 150.00,
        'pickup_date' => now()->subDays(10),
    ]);

    Rental::factory()->create([
        'value' => 250.50,
        'pickup_date' => now()->subDays(20),
    ]);

    // Rental outside period
    Rental::factory()->create([
        'value' => 100.00,
        'pickup_date' => now()->subMonths(2),
    ]);

    $response = $this->get(route('dashboard', ['period' => '1']));

    $response->assertInertia(fn ($page) => $page
        ->where('stats.totalRevenue', 400.50)
    );
});

test('dashboard defaults to 1 month period', function () {
    $response = $this->get(route('dashboard'));

    $response->assertInertia(fn ($page) => $page
        ->where('period', '1')
    );
});

test('dashboard accepts different period values', function ($period) {
    $response = $this->get(route('dashboard', ['period' => $period]));

    $response->assertInertia(fn ($page) => $page
        ->where('period', $period)
    );
})->with(['1', '3', '6', '12']);
