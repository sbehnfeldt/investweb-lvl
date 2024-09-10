<?php

namespace Database\Seeders;

use App\Models\Fund;
use App\Models\Quote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fundIds = Fund::all()->pluck('id')->toArray();
        foreach ($fundIds as $fundId) {
            Quote::factory()->count(1)->make()->each(function ($quote) use ($fundId) {
                $quote->fund_id = $fundId;

                $quote->save();
            });
        }
    }
}
