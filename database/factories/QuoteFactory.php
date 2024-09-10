<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'open'               => null,
            'high'               => null,
            'low'                => null,
            'price'              => fake()->randomFloat(2, 1, 100),
//            'price' => null,
            'volume'             => null,
            'latest_trading_day' => date('d.m.Y', strtotime("-1 days")),
            'previous_close'     => null,
        ];
    }
}
