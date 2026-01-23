<?php

namespace Database\Factories;

use App\Models\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'image' => null,
            'item_type_id' => ItemType::factory(),
            'status' => fake()->randomElement(['disponivel', 'alugado', 'indisponivel']),
        ];
    }

    public function disponivel(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'disponivel',
        ]);
    }

    public function alugado(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'alugado',
        ]);
    }

    public function indisponivel(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'indisponivel',
        ]);
    }
}
