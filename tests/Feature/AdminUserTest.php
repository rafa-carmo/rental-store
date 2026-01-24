<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class)->group('admin-users');

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can display admin users index page', function () {
    $users = User::factory()->count(3)->create();

    $this->get(route('admin-users.index'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('AdminUsers/Index')
            ->has('users', 4) // 3 created + 1 from beforeEach
        );
});

test('can display create admin user page', function () {
    $this->get(route('admin-users.create'))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('AdminUsers/Create')
        );
});

test('can store a new admin user', function () {
    $data = [
        'name' => 'Admin User',
        'email' => 'admin@email.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'admin',
    ];

    $this->post(route('admin-users.store'), $data)
        ->assertRedirect(route('admin-users.index'));

    $this->assertDatabaseHas('users', [
        'name' => 'Admin User',
        'email' => 'admin@email.com',
        'role' => 'admin',
    ]);

    $user = User::where('email', 'admin@email.com')->first();
    expect(Hash::check('password123', $user->password))->toBeTrue();
});

test('can store a regular user', function () {
    $data = [
        'name' => 'Regular User',
        'email' => 'user@email.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'user',
    ];

    $this->post(route('admin-users.store'), $data)
        ->assertRedirect(route('admin-users.index'));

    $this->assertDatabaseHas('users', [
        'name' => 'Regular User',
        'email' => 'user@email.com',
        'role' => 'user',
    ]);
});

test('requires name when storing user', function () {
    $this->post(route('admin-users.store'), [
        'email' => 'test@email.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'admin',
    ])->assertInvalid(['name']);
});

test('requires email when storing user', function () {
    $this->post(route('admin-users.store'), [
        'name' => 'Test Name',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'admin',
    ])->assertInvalid(['email']);
});

test('validates email format when storing user', function () {
    $this->post(route('admin-users.store'), [
        'name' => 'Test Name',
        'email' => 'invalid-email',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'admin',
    ])->assertInvalid(['email']);
});

test('requires unique email when storing user', function () {
    $existingUser = User::factory()->create(['email' => 'existing@email.com']);

    $this->post(route('admin-users.store'), [
        'name' => 'Test Name',
        'email' => 'existing@email.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'admin',
    ])->assertInvalid(['email']);
});

test('requires password when storing user', function () {
    $this->post(route('admin-users.store'), [
        'name' => 'Test Name',
        'email' => 'test@email.com',
        'role' => 'admin',
    ])->assertInvalid(['password']);
});

test('requires password confirmation when storing user', function () {
    $this->post(route('admin-users.store'), [
        'name' => 'Test Name',
        'email' => 'test@email.com',
        'password' => 'password123',
        'password_confirmation' => 'different',
        'role' => 'admin',
    ])->assertInvalid(['password']);
});

test('requires role when storing user', function () {
    $this->post(route('admin-users.store'), [
        'name' => 'Test Name',
        'email' => 'test@email.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertInvalid(['role']);
});

test('validates role value when storing user', function () {
    $this->post(route('admin-users.store'), [
        'name' => 'Test Name',
        'email' => 'test@email.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'invalid-role',
    ])->assertInvalid(['role']);
});

test('can display edit admin user page', function () {
    $user = User::factory()->create();

    $this->get(route('admin-users.edit', $user))
        ->assertSuccessful()
        ->assertInertia(fn ($page) => $page
            ->component('AdminUsers/Edit')
            ->has('user')
            ->where('user.id', $user->id)
        );
});

test('can update a user', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'Updated Name',
        'email' => 'updated@email.com',
        'role' => 'admin',
    ];

    $this->put(route('admin-users.update', $user), $data)
        ->assertRedirect(route('admin-users.index'));

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@email.com',
        'role' => 'admin',
    ]);
});

test('can update user password', function () {
    $user = User::factory()->create();

    $data = [
        'name' => $user->name,
        'email' => $user->email,
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
        'role' => $user->role,
    ];

    $this->put(route('admin-users.update', $user), $data)
        ->assertRedirect(route('admin-users.index'));

    $user->refresh();
    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
});

test('keeps existing password when not provided', function () {
    $user = User::factory()->create(['password' => Hash::make('oldpassword')]);
    $oldPassword = $user->password;

    $data = [
        'name' => 'Updated Name',
        'email' => $user->email,
        'role' => 'admin',
    ];

    $this->put(route('admin-users.update', $user), $data)
        ->assertRedirect(route('admin-users.index'));

    $user->refresh();
    expect($user->password)->toBe($oldPassword);
});

test('requires name when updating user', function () {
    $user = User::factory()->create();

    $this->put(route('admin-users.update', $user), [
        'email' => 'test@email.com',
        'role' => 'admin',
    ])->assertInvalid(['name']);
});

test('can delete a user', function () {
    $user = User::factory()->create();

    $this->delete(route('admin-users.destroy', $user))
        ->assertRedirect(route('admin-users.index'));

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

test('can create admin user using factory state', function () {
    $admin = User::factory()->admin()->create();

    expect($admin)->toBeInstanceOf(User::class)
        ->and($admin->role)->toBe('admin');
});

test('default user factory creates regular user', function () {
    $user = User::factory()->create();

    expect($user->role)->toBe('user');
});
