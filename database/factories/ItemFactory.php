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
        $quantityTotal = fake()->numberBetween(1, 10);
        $quantityAvailable = fake()->numberBetween(0, $quantityTotal);

        $status = $quantityAvailable === 0 ? 'alugado' : 'disponivel';

        return [
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'image' => null,
            'item_type_id' => ItemType::factory(),
            'quantity_total' => $quantityTotal,
            'quantity_available' => $quantityAvailable,
            'status' => $status,
        ];
    }

    public function disponivel(): static
    {
        return $this->state(function (array $attributes) {
            $quantityTotal = $attributes['quantity_total'] ?? 5;

            return [
                'quantity_total' => $quantityTotal,
                'quantity_available' => $quantityTotal,
                'status' => 'disponivel',
            ];
        });
    }

    public function alugado(): static
    {
        return $this->state(function (array $attributes) {
            $quantityTotal = $attributes['quantity_total'] ?? 5;

            return [
                'quantity_total' => $quantityTotal,
                'quantity_available' => 0,
                'status' => 'alugado',
            ];
        });
    }

    public function indisponivel(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'indisponivel',
        ]);
    }
}
