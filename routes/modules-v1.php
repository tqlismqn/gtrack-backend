<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Drivers\DriversController;

Route::prefix('v1')->group(function () {
    Route::prefix('drivers')->group(function () {
        Route::post('/', [DriversController::class, 'createOne']);
        Route::get('/',  [DriversController::class, 'readMany']);
        Route::get('/{id}', [DriversController::class, 'readOne']);
        Route::put('/{id}', [DriversController::class, 'updateOne']);
        Route::delete('/{id}', [DriversController::class, 'deleteOne']);
    });
});
