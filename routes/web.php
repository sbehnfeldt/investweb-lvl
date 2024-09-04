<?php

use App\Http\Controllers\Pages\FundController;
use App\Http\Controllers\Pages\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('funds', FundController::class);
//    Route::get('/funds/{fund:symbol}', [FundController::class, 'show'])->name('fundBySymbol');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
