<?php

use App\Models\MutualFund;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mutual_funds', function () {
    return view('mutual_funds', [
        'mutualFunds' => [
            ['name' => 'Bobo Fund', 'symbol' => 'BOBO', 'description' => 'A test mutual fund']
        ]
    ]);
});

Route::get('/api/mutual_funds', function () {
    return MutualFund::all();
});
