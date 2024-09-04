<?php

use App\Http\Controllers\Api\FundController;
use Illuminate\Support\Facades\Route;


// Currently does not have authorization middleware,
// since session-based authorization doesn't work for API calls.
// Will require Sanctum, Passport or other, similar package
Route::apiResource('funds', FundController::class);
