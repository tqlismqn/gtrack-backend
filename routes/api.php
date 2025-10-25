<?php

use App\Http\Controllers\Api\DriverController;
use Illuminate\Support\Facades\Route;

Route::prefix('v0')->group(function () {
    Route::get('/health', function () {
        try {
            // Check database connection
            $dbConnected = \Illuminate\Support\Facades\DB::connection()->getPdo() !== null;
            
            // Check if drivers exist
            $driversCount = \App\Models\Driver::count();
            
            return response()->json([
                'status' => 'ok',
                'version' => '0.1.0',
                'database' => $dbConnected ? 'connected' : 'disconnected',
                'drivers_count' => $driversCount,
                'timestamp' => now()->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    });

    // Database stats endpoint (for debugging)
    Route::get('/stats', function () {
        return response()->json([
            'drivers' => \App\Models\Driver::count(),
            'documents' => \App\Models\DriverDocument::count(),
            'files' => \App\Models\DocumentFile::count(),
            'comments' => \App\Models\DriverComment::count(),
            'users' => \App\Models\User::count(),
        ]);
    });

    Route::apiResource('drivers', DriverController::class);
});
