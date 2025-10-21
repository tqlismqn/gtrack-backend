<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', fn() => response()->json(['ok' => true, 'service' => 'gtrack-backend', 'ts' => now()->toISOString()]));

require __DIR__.'/modules-v1.php';
require __DIR__.'/admin-v1.php';
