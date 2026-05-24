<?php

use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

Route::name('public.')->group(function (): void {
    Route::view('/', 'pages.home')->name('home');
    Route::view('/features', 'pages.features')->name('features');
    Route::view('/security', 'pages.security')->name('security');
    Route::view('/download', 'pages.download')->name('download');
    Route::view('/docs', 'pages.docs')->name('docs');
    Route::view('/pricing', 'pages.pricing')->name('pricing');
    Route::view('/privacy', 'pages.privacy')->name('privacy');
    Route::view('/terms', 'pages.terms')->name('terms');
    Route::get('/health', HealthController::class)->name('health');
});

Route::name('auth.')->group(function (): void {
    Route::view('/login', 'pages.login')->name('login');
    Route::view('/register', 'pages.register')->name('register');
});

Route::view('/device', 'pages.device')->name('device.activation');

Route::prefix('account')->name('account.')->group(function (): void {
    Route::view('/', 'pages.account')->name('dashboard');
});
