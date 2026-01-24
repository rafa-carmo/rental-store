<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Rental;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $items = Item::all();

        if ($customers->isEmpty() || $items->isEmpty()) {
            return;
        }

        Rental::create([
            'customer_id' => $customers->first()->id,
            'item_id' => $items->first()->id,
            'value' => 150.00,
            'pickup_date' => now()->subDays(5),
            'return_date' => now()->addDays(10),
        ]);

        Rental::create([
            'customer_id' => $customers->skip(1)->first()->id,
            'item_id' => $items->skip(1)->first()->id,
            'value' => 250.50,
            'pickup_date' => now()->subDays(2),
            'return_date' => now()->addDays(7),
        ]);

        Rental::create([
            'customer_id' => $customers->skip(2)->first()->id ?? $customers->first()->id,
            'item_id' => $items->skip(2)->first()->id ?? $items->first()->id,
            'value' => 89.99,
            'pickup_date' => now(),
            'return_date' => now()->addDays(5),
        ]);
    }
}
