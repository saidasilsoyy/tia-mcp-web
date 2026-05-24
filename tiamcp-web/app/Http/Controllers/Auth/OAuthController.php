<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Audit\LoginEventRecorder;
use App\Services\OAuth\OAuthAccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class OAuthController extends Controller
{
    public function redirect(string $provider): SymfonyRedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(
        Request $request,
        string $provider,
        OAuthAccountService $accounts,
        LoginEventRecorder $events
    ): RedirectResponse {
        $socialiteUser = Socialite::driver($provider)->user();
        $user = $accounts->resolveUser($provider, $socialiteUser, $request->user());

        Auth::login($user);
        $request->session()->regenerate();
        $user->update(['last_login_at' => now()]);
        $events->record($request, 'oauth_login', $user, $user->email, ['provider' => $provider]);

        return redirect()->route($user->hasVerifiedEmail() ? 'account.dashboard' : 'verification.notice');
    }
}
