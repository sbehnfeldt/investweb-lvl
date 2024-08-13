<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fund>
 */
class FundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => ucwords(join(' ', fake()->words())) . ' Fund',
            'symbol' => strtoupper( fake()->lexify(str_repeat('?', rand(4,8)))),
            'description' => fake()->text
        ];
    }
}
