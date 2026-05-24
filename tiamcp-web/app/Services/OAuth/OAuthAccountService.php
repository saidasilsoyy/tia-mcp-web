<?php

namespace App\Services\OAuth;

use App\Models\OAuthAccount;
use App\Models\User;
use App\Services\Billing\SubscriptionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class OAuthAccountService
{
    public function __construct(private readonly SubscriptionService $subscriptionService) {}

    public function resolveUser(string $provider, SocialiteUser $socialiteUser, ?User $currentUser = null): User
    {
        return DB::transaction(function () use ($provider, $socialiteUser, $currentUser): User {
            $providerId = (string) $socialiteUser->getId();
            $email = $socialiteUser->getEmail();
            $verified = $this->providerEmailVerified($provider, $socialiteUser);

            $account = OAuthAccount::where('provider', $provider)
                ->where('provider_user_id', $providerId)
                ->first();

            if ($account) {
                $account->update([
                    'provider_email' => $email,
                    'provider_email_verified' => $verified,
                    'provider_username' => $socialiteUser->getNickname(),
                    'last_used_at' => now(),
                ]);

                return User::findOrFail($account->user_id);
            }

            $user = $currentUser ?? $this->findVerifiedEmailUser($email, $verified) ?? User::create([
                'name' => $socialiteUser->getName() ?: $socialiteUser->getNickname() ?: 'TIA MCP User',
                'email' => $email ?: sprintf('%s-%s@oauth.tiamcp.local', $provider, Str::uuid()),
                'email_verified_at' => $verified ? now() : null,
                'password' => Str::password(48),
                'status' => 'active',
            ]);

            OAuthAccount::create([
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_user_id' => $providerId,
                'provider_email' => $email,
                'provider_email_verified' => $verified,
                'provider_username' => $socialiteUser->getNickname(),
                'linked_at' => now(),
                'last_used_at' => now(),
            ]);

            $this->subscriptionService->ensureLaunchSubscription($user);

            return $user;
        });
    }

    private function findVerifiedEmailUser(?string $email, bool $verified): ?User
    {
        if (! $verified || $email === null) {
            return null;
        }

        return User::where('email', $email)
            ->whereNotNull('email_verified_at')
            ->first();
    }

    private function providerEmailVerified(string $provider, SocialiteUser $socialiteUser): bool
    {
        $raw = $this->rawUser($socialiteUser);

        return match ($provider) {
            'google' => (bool) ($raw['email_verified'] ?? false),
            'github' => $socialiteUser->getEmail() !== null,
            default => false,
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function rawUser(mixed $socialiteUser): array
    {
        $raw = $socialiteUser->user ?? [];

        return is_array($raw) ? $raw : [];
    }
}
