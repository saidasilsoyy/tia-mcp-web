<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Services\GitHub\GitHubOAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class GitHubConnectionController extends Controller
{
    public function show(Request $request)
    {
        return view('account.integrations.github', [
            'connection' => $request->user()->githubConnection,
        ]);
    }

    public function redirect(): SymfonyRedirectResponse
    {
        config(['services.github' => config('services.github_product')]);

        return Socialite::driver('github')->redirect();
    }

    public function callback(Request $request, GitHubOAuthService $github): RedirectResponse
    {
        config(['services.github' => config('services.github_product')]);

        $githubUser = Socialite::driver('github')->user();
        $scopes = $this->scopesFromResponse($githubUser);
        $github->connect($request->user(), $githubUser, $scopes);

        return redirect()->route('account.github.show')->with('status', 'GitHub product connection updated.');
    }

    public function disconnect(Request $request, GitHubOAuthService $github): RedirectResponse
    {
        $github->disconnect($request->user());

        return back()->with('status', 'GitHub product connection disconnected.');
    }

    /**
     * @return array<int, string>
     */
    private function scopesFromResponse(mixed $githubUser): array
    {
        $approvedScopes = $githubUser->approvedScopes ?? [];
        if (is_string($approvedScopes)) {
            return array_values(array_filter(array_map('trim', explode(',', $approvedScopes))));
        }

        return is_array($approvedScopes) ? array_values($approvedScopes) : [];
    }
}
