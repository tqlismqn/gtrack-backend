<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v0')->group(function () {
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'version' => '0.1.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    });

    // Future routes will be added here
    // Route::apiResource('drivers', DriverController::class);
});
