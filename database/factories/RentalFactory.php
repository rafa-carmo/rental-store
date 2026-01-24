<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pickupDate = fake()->dateTimeBetween('-30 days', '+30 days');
        $returnDate = fake()->dateTimeBetween($pickupDate, '+60 days');

        return [
            'customer_id' => Customer::factory(),
            'item_id' => Item::factory(),
            'value' => fake()->randomFloat(2, 50, 500),
            'pickup_date' => $pickupDate,
            'return_date' => $returnDate,
        ];
    }
}
