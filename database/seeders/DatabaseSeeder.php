<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Fund;
use App\Models\Transaction;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

//        Fund::factory(10)->create();

        $this->call([
            FundSeeder::class,
            AccountSeeder::class,
            TransactionSeeder::class
        ]);
    }
}
