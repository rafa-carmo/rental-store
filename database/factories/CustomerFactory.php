<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->optional(0.8)->phoneNumber(),
            'email' => fake()->optional(0.8)->safeEmail(),
            'cep' => fake()->optional(0.7)->numerify('#####-###'),
            'street' => fake()->optional(0.7)->streetName(),
            'number' => fake()->optional(0.7)->buildingNumber(),
            'complement' => fake()->optional(0.5)->secondaryAddress(),
            'state' => fake()->optional(0.7)->stateAbbr(),
            'city' => fake()->optional(0.7)->city(),
        ];
    }
}
