<?php

use App\Http\Controllers\MutualFundController;
use App\Models\MutualFund;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mutual_funds', [MutualFundController::class, 'index'])
    ->name( 'mutual_funds' );

Route::get('/api/mutual_funds', function () {
    return MutualFund::all();
});
