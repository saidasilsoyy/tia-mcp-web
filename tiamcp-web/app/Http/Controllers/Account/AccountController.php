<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Services\Billing\SubscriptionService;
use App\Services\Entitlements\EntitlementResolver;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __invoke(Request $request, SubscriptionService $subscriptions, EntitlementResolver $resolver): View
    {
        $user = $request->user();
        $subscriptions->ensureLaunchSubscription($user);

        return view('account.dashboard', [
            'summary' => $resolver->resolve($user),
            'devices' => $user->devices()->latest()->limit(5)->get(),
            'githubConnection' => $user->githubConnection,
        ]);
    }
}
