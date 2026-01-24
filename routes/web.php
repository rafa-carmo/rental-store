<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::resource('item-types', ItemTypeController::class)->except(['show']);
    Route::resource('items', ItemController::class)->except(['show']);
    Route::resource('customers', CustomerController::class)->except(['show']);
    Route::resource('admin-users', AdminUserController::class)->except(['show']);
    Route::resource('rentals', RentalController::class)->except(['show']);
});

require __DIR__.'/settings.php';
