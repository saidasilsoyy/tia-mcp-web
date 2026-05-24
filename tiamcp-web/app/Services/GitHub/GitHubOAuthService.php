<?php

namespace App\Services\GitHub;

use App\Models\GitHubConnection;
use App\Models\GitHubConnectionEvent;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class GitHubOAuthService
{
    /**
     * @param  array<int, string>  $scopes
     */
    public function connect(User $user, SocialiteUser $githubUser, array $scopes = []): GitHubConnection
    {
        return DB::transaction(function () use ($user, $githubUser, $scopes): GitHubConnection {
            GitHubConnection::where('user_id', $user->id)
                ->whereNull('revoked_at')
                ->update([
                    'revoked_at' => now(),
                    'status' => 'revoked',
                ]);

            $connection = GitHubConnection::create([
                'user_id' => $user->id,
                'github_user_id' => (string) $githubUser->getId(),
                'github_username' => $githubUser->getNickname(),
                'scopes' => $scopes,
                'encrypted_access_token' => Crypt::encryptString($this->stringProperty($githubUser, 'token')),
                'encrypted_refresh_token' => $this->nullableStringProperty($githubUser, 'refreshToken') ? Crypt::encryptString((string) $this->nullableStringProperty($githubUser, 'refreshToken')) : null,
                'token_expires_at' => $this->nullableIntProperty($githubUser, 'expiresIn') ? now()->addSeconds((int) $this->nullableIntProperty($githubUser, 'expiresIn')) : null,
                'last_verified_at' => now(),
                'status' => 'connected',
            ]);

            GitHubConnectionEvent::create([
                'github_connection_id' => $connection->id,
                'user_id' => $user->id,
                'event_type' => 'connected',
                'metadata' => [
                    'github_user_id' => $connection->github_user_id,
                    'github_username' => $connection->github_username,
                    'scopes' => $scopes,
                ],
            ]);

            return $connection;
        });
    }

    public function disconnect(User $user): void
    {
        $connection = GitHubConnection::where('user_id', $user->id)->whereNull('revoked_at')->first();
        if (! $connection) {
            return;
        }

        $connection->update([
            'revoked_at' => now(),
            'status' => 'revoked',
        ]);

        GitHubConnectionEvent::create([
            'github_connection_id' => $connection->id,
            'user_id' => $user->id,
            'event_type' => 'disconnected',
            'metadata' => [],
        ]);
    }

    private function stringProperty(mixed $value, string $property): string
    {
        return (string) ($value->{$property} ?? '');
    }

    private function nullableStringProperty(mixed $value, string $property): ?string
    {
        $propertyValue = $value->{$property} ?? null;

        return $propertyValue === null ? null : (string) $propertyValue;
    }

    private function nullableIntProperty(mixed $value, string $property): ?int
    {
        $propertyValue = $value->{$property} ?? null;

        return $propertyValue === null ? null : (int) $propertyValue;
    }
}
