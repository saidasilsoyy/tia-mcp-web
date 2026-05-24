<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\DeviceController;
use App\Http\Controllers\Account\GitHubConnectionController;
use App\Http\Controllers\Admin\AuditLogController as AdminAuditLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DeviceController as AdminDeviceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
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

Route::middleware('guest')->name('auth.')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:login');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:registration');
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('throttle:password-reset')->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::post('/logout', LogoutController::class)->middleware('auth')->name('auth.logout');

Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect'])
    ->whereIn('provider', ['google', 'github'])
    ->middleware('throttle:oauth')
    ->name('auth.oauth.redirect');
Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback'])
    ->whereIn('provider', ['google', 'github'])
    ->middleware('throttle:oauth')
    ->name('auth.oauth.callback');

Route::get('/email/verify', EmailVerificationPromptController::class)
    ->middleware('auth')
    ->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:verification'])
    ->name('verification.verify');

Route::get('/device', [DeviceController::class, 'showActivation'])->name('device.activation');
Route::post('/device/approve', [DeviceController::class, 'approve'])
    ->middleware(['auth', 'verified', 'throttle:device-approve'])
    ->name('device.approve');

Route::prefix('account')->middleware(['auth', 'verified'])->name('account.')->group(function (): void {
    Route::get('/', AccountController::class)->name('dashboard');
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::post('/devices/{device}/revoke', [DeviceController::class, 'revoke'])->name('devices.revoke');
    Route::get('/github', [GitHubConnectionController::class, 'show'])->name('github.show');
    Route::post('/github/disconnect', [GitHubConnectionController::class, 'disconnect'])->name('github.disconnect');
    Route::get('/github/redirect', [GitHubConnectionController::class, 'redirect'])
        ->middleware('throttle:oauth')
        ->name('github.redirect');
    Route::get('/github/callback', [GitHubConnectionController::class, 'callback'])
        ->middleware('throttle:oauth')
        ->name('github.callback');
});

Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->name('admin.')->group(function (): void {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
    Route::patch('/users/{user}/status', [AdminUserController::class, 'updateStatus'])->name('users.status');
    Route::get('/devices', [AdminDeviceController::class, 'index'])->name('devices.index');
    Route::post('/devices/{device}/revoke', [AdminDeviceController::class, 'revoke'])->name('devices.revoke');
    Route::get('/audit', [AdminAuditLogController::class, 'index'])->name('audit.index');
});
