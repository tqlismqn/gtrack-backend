<?php

use App\Http\Controllers\Api\DriverController;
use Illuminate\Support\Facades\Route;

Route::prefix('v0')->group(function () {
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'version' => '0.1.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    });

    Route::apiResource('drivers', DriverController::class);
});
