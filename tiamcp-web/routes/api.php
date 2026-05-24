<?php

use App\Http\Controllers\Api\MetaController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    Route::get('/health', HealthController::class)->name('health');
    Route::get('/meta', MetaController::class)->name('meta');
});
