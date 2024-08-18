<?php

use App\Http\Controllers\FundController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('funds', FundController::class);

//    Route::get('/funds', [FundController::class, 'index'])->name('funds.index');
//    Route::get('/funds/create', [FundController::class, 'create'])->name('funds.create');
//    Route::post( '/funds', [FundController::class, 'store'])->name( 'funds.store' );
//    Route::get('/funds/{fund}', [FundController::class, 'show'])->where('fund', '[0-9]+')->name('funds.show');
//    Route::get('/funds/{fund}/edit', [FundController::class, 'edit'])->where('fund', '[0-9]+')->name('funds.edit');
//    Route::put('/funds/{fund}', [FundController::class, 'update'])->where('fund', '[0-9]+')->name('funds.update');
//    Route::delete('/funds/{fund}', [FundController::class, 'destroy'])->where('fund', '[0-9]+')->name('funds.destroy');

    //    Route::get('/funds/{fund:symbol}', [FundController::class, 'show'])->name('fundBySymbol');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
