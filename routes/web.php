<?php

use App\Http\Controllers\FundController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/funds', [FundController::class, 'index'])->name('funds');
    Route::get('/funds/{fund}', [FundController::class, 'show'])->where('fund', '[0-9]+')->name('fund');
//    Route::get('/funds/{fund:symbol}', [FundController::class, 'show'])->name('fundBySymbol');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
