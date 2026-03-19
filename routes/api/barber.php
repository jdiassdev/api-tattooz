<?php

use App\Http\Controllers\Barbers\BarbersController;
use Illuminate\Support\Facades\Route;

Route::prefix('barbers')->name('barbers.')->group(function () {

    Route::get('/', [BarbersController::class, 'index'])->name('index');
    Route::get('/{id}', [BarbersController::class, 'show'])->name('show');
    Route::get('/{id}/availability', [BarbersController::class, 'availability'])->name('availability');


    Route::middleware('jwt')->group(function () {
        Route::post('/store', [BarbersController::class, 'store'])->name('store');
    });
});
