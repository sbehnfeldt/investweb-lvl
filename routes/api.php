<?php

use App\Models\Fund;
use Illuminate\Support\Facades\Route;


Route::get('/funds', function () {
    return Fund::all();
});

