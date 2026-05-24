<?php

namespace App\Services\Entitlements;

use App\Enums\EntitlementCode;
use App\Models\Device;
use App\Models\GitHubConnection;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;

class EntitlementResolver
{
    /**
     * @return array<string, mixed>
     */
    public function resolve(User $user, ?Device $device = null): array
    {
        $githubConnected = GitHubConnection::where('user_id', $user->id)
            ->whereNull('revoked_at')
            ->latest()
            ->first()?->isConnected() ?? false;
        $subscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where(function ($query): void {
                $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->latest()
            ->first();
        $accountActive = $user->isActive() && $user->hasVerifiedEmail();
        $deviceActive = $device === null || $device->isActive();

        $codes = [];
        $planCode = null;
        $subscriptionStatus = 'none';

        if ($accountActive && $deviceActive && $subscription?->isActive()) {
            $plan = Plan::with('entitlements')->find($subscription->plan_id);
            if (! $plan) {
                return [
                    'account' => [
                        'status' => $user->status,
                        'email_verified' => $user->hasVerifiedEmail(),
                    ],
                    'subscription' => [
                        'plan' => null,
                        'status' => 'missing_plan',
                    ],
                    'github' => [
                        'connected' => $githubConnected,
                        'status' => $githubConnected ? 'connected' : 'not_connected',
                    ],
                    'device' => [
                        'id' => $device?->device_public_id,
                        'status' => $device?->status,
                    ],
                    'entitlements' => [],
                    'expires_at' => now()->addMinutes((int) config('tiamcp.entitlement_offline_window_minutes'))->toIso8601String(),
                ];
            }

            $planCode = $plan->code;
            $subscriptionStatus = $subscription->status;
            $codes = $plan->entitlements
                ->pluck('code')
                ->filter(fn (string $code): bool => $code !== EntitlementCode::GitHubConnected->value || $githubConnected)
                ->sort()
                ->values()
                ->all();
        }

        return [
            'account' => [
                'status' => $user->status,
                'email_verified' => $user->hasVerifiedEmail(),
            ],
            'subscription' => [
                'plan' => $planCode,
                'status' => $subscriptionStatus,
            ],
            'github' => [
                'connected' => $githubConnected,
                'status' => $githubConnected ? 'connected' : 'not_connected',
            ],
            'device' => [
                'id' => $device?->device_public_id,
                'status' => $device?->status,
            ],
            'entitlements' => $codes,
            'expires_at' => now()->addMinutes((int) config('tiamcp.entitlement_offline_window_minutes'))->toIso8601String(),
        ];
    }
}
