<?php

use App\Models\MutualFund;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mutual_funds', function() {
    return view( 'mutual_funds');
});

Route::get( '/api/mutual_funds', function() {
    return MutualFund::all();
});
