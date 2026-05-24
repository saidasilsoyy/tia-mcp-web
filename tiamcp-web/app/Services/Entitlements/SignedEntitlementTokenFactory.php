<?php

namespace App\Services\Entitlements;

use App\Models\Device;
use App\Models\EntitlementToken;
use App\Models\User;
use RuntimeException;

class SignedEntitlementTokenFactory
{
    public function __construct(private readonly EntitlementResolver $resolver) {}

    /**
     * @return array<string, mixed>
     */
    public function make(User $user, ?Device $device = null): array
    {
        $expiresAt = now()->addMinutes((int) config('tiamcp.entitlement_offline_window_minutes'));
        $payload = [
            'iss' => config('app.url'),
            'sub' => (string) $user->id,
            'device' => $device?->device_public_id,
            'summary' => $this->resolver->resolve($user, $device),
            'iat' => now()->toIso8601String(),
            'exp' => $expiresAt->toIso8601String(),
            'key_id' => (string) config('tiamcp.entitlement_signing_key_id'),
        ];

        $encodedPayload = $this->base64UrlEncode(json_encode($payload, JSON_THROW_ON_ERROR));
        $signature = $this->sign($encodedPayload);

        EntitlementToken::create([
            'user_id' => $user->id,
            'device_id' => $device?->id,
            'key_id' => (string) config('tiamcp.entitlement_signing_key_id'),
            'payload_hash' => hash('sha256', $encodedPayload),
            'expires_at' => $expiresAt,
        ]);

        return [
            'key_id' => (string) config('tiamcp.entitlement_signing_key_id'),
            'algorithm' => (string) config('tiamcp.entitlement_signing_alg'),
            'payload' => $encodedPayload,
            'signature' => $signature,
            'expires_at' => $expiresAt->toIso8601String(),
        ];
    }

    public function verify(string $payload, string $signature): bool
    {
        if ((string) config('tiamcp.entitlement_signing_alg') === 'RS256') {
            $publicKey = $this->publicKey();
            $decodedSignature = base64_decode(strtr($signature, '-_', '+/'), true);

            if ($decodedSignature === false) {
                return false;
            }

            return openssl_verify($payload, $decodedSignature, $publicKey, OPENSSL_ALGO_SHA256) === 1;
        }

        return hash_equals($this->sign($payload), $signature);
    }

    private function sign(string $payload): string
    {
        if ((string) config('tiamcp.entitlement_signing_alg') === 'RS256') {
            $signature = '';
            $signed = openssl_sign($payload, $signature, $this->privateKey(), OPENSSL_ALGO_SHA256);
            if (! $signed) {
                throw new RuntimeException('Failed to sign entitlement payload.');
            }

            return $this->base64UrlEncode($signature);
        }

        $secret = (string) config('tiamcp.entitlement_signing_secret');
        if ($secret === '') {
            throw new RuntimeException('Entitlement signing secret is not configured.');
        }

        if (str_starts_with($secret, 'base64:')) {
            $secret = (string) base64_decode(substr($secret, 7), true);
        }

        return $this->base64UrlEncode(hash_hmac('sha256', $payload, $secret, true));
    }

    private function privateKey(): string
    {
        $path = (string) config('tiamcp.entitlement_signing_private_key_path');
        if ($path === '' || ! is_file($path)) {
            throw new RuntimeException('Entitlement signing private key is not configured.');
        }

        return (string) file_get_contents($path);
    }

    private function publicKey(): string
    {
        $path = (string) config('tiamcp.entitlement_signing_public_key_path');
        if ($path === '' || ! is_file($path)) {
            throw new RuntimeException('Entitlement signing public key is not configured.');
        }

        return (string) file_get_contents($path);
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
