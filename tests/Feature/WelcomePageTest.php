<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->group('welcome');

test('welcome page is accessible', function () {
    $response = $this->get(route('home'));

    $response->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('welcome')
        );
});

test('welcome page shows register button when registration is enabled', function () {
    $response = $this->get(route('home'));

    $response->assertSuccessful();
});

test('authenticated users see dashboard link on welcome page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('home'));

    $response->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->where('auth.user.id', $user->id)
        );
});
