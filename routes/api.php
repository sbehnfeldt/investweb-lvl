<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\FundController;
use App\Http\Controllers\Api\QuotesController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;


// Currently does not have authorization middleware,
// since session-based authorization doesn't work for API calls.
// Will require Sanctum, Passport or other, similar package
Route::apiResource('funds', FundController::class);
Route::apiResource('accounts', AccountController::class);
Route::apiResource('transactions', TransactionController::class);

Route::apiResource('quotes', QuotesController::class);
