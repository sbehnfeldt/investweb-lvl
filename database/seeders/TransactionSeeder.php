<?php

namespace Database\Seeders;

use App\Models\Fund;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fundIds    = Fund::all()->pluck('id')->toArray();
        $accountIds = Account::all()->pluck('id')->toArray();

        Transaction::factory()->count(200)->make()->each(function ($transaction) use ($fundIds, $accountIds) {
            $transaction->fund_id    = $fundIds[array_rand($fundIds)];
            $transaction->account_id = $accountIds[array_rand($accountIds)];
            $transaction->save();
        });
    }
}
