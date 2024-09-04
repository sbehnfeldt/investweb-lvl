<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'acquired'       => fake()->date(),
            'quantity'       => fake()->randomFloat(3, 0.01, 1000),
            'avg_cost_basis' => fake()->randomFloat(2, 1, 100),
        ];
    }
}
