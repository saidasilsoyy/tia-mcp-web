<?php

namespace App\Services\Devices;

use App\Models\Device;
use App\Models\DeviceToken;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DeviceTokenService
{
    /**
     * @return array<string, mixed>
     */
    public function issue(Device $device): array
    {
        $accessToken = Str::random(80);
        $refreshToken = Str::random(96);
        $accessExpiresAt = now()->addMinutes((int) config('tiamcp.device_access_token_ttl_minutes'));
        $refreshExpiresAt = now()->addDays((int) config('tiamcp.device_refresh_token_ttl_days'));

        $token = DeviceToken::create([
            'device_id' => $device->id,
            'access_token_hash' => $this->hash($accessToken),
            'access_token_expires_at' => $accessExpiresAt,
            'refresh_token_hash' => $this->hash($refreshToken),
            'last_used_at' => now(),
            'expires_at' => $refreshExpiresAt,
        ]);

        return [
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_in' => $accessExpiresAt->diffInSeconds(now()),
            'refresh_token' => $refreshToken,
            'refresh_expires_at' => $refreshExpiresAt->toIso8601String(),
            'device' => [
                'id' => $device->device_public_id,
                'name' => $device->name,
            ],
            'token_id' => $token->id,
        ];
    }

    public function authenticateAccessToken(?string $bearerToken): ?DeviceToken
    {
        if (! $bearerToken) {
            return null;
        }

        $token = DeviceToken::with('device.user')
            ->where('access_token_hash', $this->hash($bearerToken))
            ->whereNull('revoked_at')
            ->first();

        if (! $token || Carbon::parse($token->access_token_expires_at)->isPast() || ! $token->isUsable()) {
            return null;
        }

        $token->update(['last_used_at' => now()]);
        $device = Device::find($token->device_id);
        $device?->update(['last_seen_at' => now()]);

        return $token;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function refresh(string $refreshToken): ?array
    {
        $token = DeviceToken::with('device')
            ->where('refresh_token_hash', $this->hash($refreshToken))
            ->whereNull('revoked_at')
            ->first();

        if (! $token || ! $token->isUsable()) {
            return null;
        }

        $device = Device::find($token->device_id);
        if (! $device) {
            return null;
        }

        $token->update(['revoked_at' => now()]);

        return $this->issue($device);
    }

    public function revokeByRefreshToken(string $refreshToken): bool
    {
        $token = DeviceToken::where('refresh_token_hash', $this->hash($refreshToken))
            ->whereNull('revoked_at')
            ->first();

        if (! $token) {
            return false;
        }

        $token->update(['revoked_at' => now()]);

        return true;
    }

    public function revoke(DeviceToken $token): void
    {
        $token->update(['revoked_at' => now()]);
    }

    private function hash(string $value): string
    {
        return hash('sha256', $value);
    }
}
