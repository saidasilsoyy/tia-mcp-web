<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', fn (Request $request): Limit => Limit::perMinute(5)->by($request->ip().'|'.strtolower((string) $request->input('email'))));
        RateLimiter::for('registration', fn (Request $request): Limit => Limit::perMinute(3)->by($request->ip()));
        RateLimiter::for('password-reset', fn (Request $request): Limit => Limit::perMinute(3)->by($request->ip().'|'.strtolower((string) $request->input('email'))));
        RateLimiter::for('verification', fn (Request $request): Limit => Limit::perMinute(6)->by((string) $request->user()?->id ?: $request->ip()));
        RateLimiter::for('oauth', fn (Request $request): Limit => Limit::perMinute(10)->by($request->ip()));
        RateLimiter::for('device-approve', fn (Request $request): Limit => Limit::perMinute(8)->by((string) $request->user()?->id ?: $request->ip()));
        RateLimiter::for('device-authorize', fn (Request $request): Limit => Limit::perMinute(20)->by($request->ip()));
        RateLimiter::for('device-token', fn (Request $request): Limit => Limit::perMinute(30)->by($request->ip()));
        RateLimiter::for('device-refresh', fn (Request $request): Limit => Limit::perMinute(20)->by($request->ip()));
        RateLimiter::for('device-revoke', fn (Request $request): Limit => Limit::perMinute(20)->by($request->ip()));
    }
}
