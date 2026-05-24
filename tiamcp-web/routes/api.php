<?php

use App\Http\Controllers\Api\MetaController;
use App\Http\Controllers\Api\V1\DeviceAuthorizationController;
use App\Http\Controllers\Api\V1\DeviceEntitlementController;
use App\Http\Controllers\Api\V1\DeviceTokenController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    Route::get('/health', HealthController::class)->name('health');
    Route::get('/meta', MetaController::class)->name('meta');
    Route::post('/devices/authorize', [DeviceAuthorizationController::class, 'store'])
        ->middleware('throttle:device-authorize')
        ->name('devices.authorize');
    Route::post('/devices/token', [DeviceTokenController::class, 'store'])
        ->middleware('throttle:device-token')
        ->name('devices.token');
    Route::post('/devices/refresh', [DeviceTokenController::class, 'refresh'])
        ->middleware('throttle:device-refresh')
        ->name('devices.refresh');
    Route::post('/devices/revoke', [DeviceTokenController::class, 'revoke'])
        ->middleware('throttle:device-revoke')
        ->name('devices.revoke');
    Route::get('/entitlements', [DeviceEntitlementController::class, 'show'])
        ->name('entitlements.show');
    Route::get('/entitlements/signed', [DeviceEntitlementController::class, 'signed'])
        ->name('entitlements.signed');
    Route::get('/entitlements/keys', [DeviceEntitlementController::class, 'keys'])
        ->name('entitlements.keys');
});
