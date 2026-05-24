<?php

namespace App\Services\Devices;

use App\Models\Device;
use App\Models\DeviceAuthorization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceAuthorizationService
{
    /**
     * @param  array<string, string|null>  $input
     * @return array<string, mixed>
     */
    public function create(array $input, Request $request): array
    {
        $deviceCode = Str::random(80);
        $userCode = $this->makeUserCode();
        $expiresAt = now()->addMinutes((int) config('tiamcp.device_authorization_expires_minutes'));

        DeviceAuthorization::create([
            'device_code_hash' => $this->hash($deviceCode),
            'user_code_hash' => $this->hash($this->normalizeUserCode($userCode)),
            'user_code_display' => $userCode,
            'status' => 'pending',
            'client_name' => $input['client_name'] ?? 'TIA MCP Desktop',
            'platform' => $input['platform'] ?? null,
            'app_version' => $input['app_version'] ?? null,
            'machine_fingerprint_hash' => isset($input['machine_fingerprint']) ? hash('sha256', (string) $input['machine_fingerprint']) : null,
            'requested_ip' => $request->ip(),
            'requested_user_agent' => (string) $request->userAgent(),
            'expires_at' => $expiresAt,
        ]);

        return [
            'device_code' => $deviceCode,
            'user_code' => $userCode,
            'verification_uri' => config('tiamcp.device_activation_url'),
            'expires_in' => $expiresAt->diffInSeconds(now()),
            'interval' => (int) config('tiamcp.device_poll_interval_seconds'),
        ];
    }

    public function approve(string $userCode, User $user): DeviceAuthorization
    {
        $authorization = DeviceAuthorization::where('user_code_hash', $this->hash($this->normalizeUserCode($userCode)))
            ->where('status', 'pending')
            ->firstOrFail();

        if ($authorization->isExpired()) {
            $authorization->update(['status' => 'expired']);
            abort(422, 'Device code expired.');
        }

        $device = Device::create([
            'user_id' => $user->id,
            'device_public_id' => (string) Str::uuid(),
            'name' => $authorization->client_name,
            'platform' => $authorization->platform,
            'app_version' => $authorization->app_version,
            'machine_fingerprint_hash' => $authorization->machine_fingerprint_hash,
            'status' => 'active',
            'last_seen_at' => now(),
        ]);

        $authorization->update([
            'user_id' => $user->id,
            'device_id' => $device->id,
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return $authorization;
    }

    public function findByDeviceCode(string $deviceCode): ?DeviceAuthorization
    {
        return DeviceAuthorization::where('device_code_hash', $this->hash($deviceCode))->first();
    }

    public function markPolled(DeviceAuthorization $authorization): void
    {
        $authorization->forceFill([
            'last_polled_at' => now(),
            'poll_count' => $authorization->poll_count + 1,
        ])->save();
    }

    private function makeUserCode(): string
    {
        do {
            $code = strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4));
        } while (DeviceAuthorization::where('user_code_hash', $this->hash($this->normalizeUserCode($code)))->exists());

        return $code;
    }

    private function normalizeUserCode(string $code): string
    {
        return strtoupper(str_replace([' ', '-'], '', $code));
    }

    private function hash(string $value): string
    {
        return hash('sha256', $value);
    }
}
