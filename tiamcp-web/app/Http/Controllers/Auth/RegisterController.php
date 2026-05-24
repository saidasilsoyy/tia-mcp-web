<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Audit\LoginEventRecorder;
use App\Services\Billing\SubscriptionService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request, SubscriptionService $subscriptionService, LoginEventRecorder $events): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'lowercase', 'email:rfc', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(12)->letters()->numbers(),
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (is_string($value) && in_array(strtolower($value), ['password123456', 'tiamcp123456', 'automation123'], true)) {
                        $fail('Choose a stronger password.');
                    }
                },
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'status' => 'active',
        ]);

        $user->profile()->create(['timezone' => config('app.timezone', 'UTC')]);
        $subscriptionService->ensureLaunchSubscription($user);
        $events->record($request, 'registration', $user);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
