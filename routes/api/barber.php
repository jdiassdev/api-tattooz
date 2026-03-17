<?php

use App\Http\Controllers\Barbers\BarbersController;
use Illuminate\Support\Facades\Route;

Route::prefix('barbers')->name('barbers.')->group(function () {
    // rota pública
    Route::get('/', [BarbersController::class, 'index'])->name('index');
    Route::get('/{id}/availability', [BarbersController::class, 'availability'])->name('availability');

    // rotas que precisam de auth via JWT
    Route::middleware('jwt')->group(function () {
        Route::get('/profile', [BarbersController::class, 'profile'])->name('profile');
        Route::post('/store', [BarbersController::class, 'store'])->name('store');
        Route::put('/{id}', [BarbersController::class, 'update'])->name('update');
        Route::delete('/{id}', [BarbersController::class, 'destroy'])->name('destroy');
    });
});
