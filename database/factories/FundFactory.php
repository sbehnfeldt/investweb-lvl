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
            'symbol'      => strtoupper(fake()->lexify(str_repeat('?', rand(4, 8)))),
            'description' => fake()->text,
            'asset_class' => fake()->randomElement(['equity', 'bond', null]),
            'sector'      => fake()->randomElement(['Industrials', 'Software', 'Health', 'Finance', null]),
            'region'      => fake()->randomElement(['Domestic', 'International', 'Global', 'Emerging Markets', null])
        ];
    }
}
