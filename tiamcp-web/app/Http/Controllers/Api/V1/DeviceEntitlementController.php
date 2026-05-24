<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use App\Services\Devices\DeviceTokenService;
use App\Services\Entitlements\EntitlementResolver;
use App\Services\Entitlements\SignedEntitlementTokenFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceEntitlementController extends Controller
{
    public function show(Request $request, DeviceTokenService $tokens, EntitlementResolver $resolver): JsonResponse
    {
        $token = $tokens->authenticateAccessToken($request->bearerToken());
        if (! $token) {
            return $this->unauthorized();
        }

        $device = Device::find($token->device_id);
        $user = $device ? User::find($device->user_id) : null;
        if (! $device || ! $user) {
            return $this->unauthorized();
        }

        return response()->json($resolver->resolve($user, $device));
    }

    public function signed(Request $request, DeviceTokenService $tokens, SignedEntitlementTokenFactory $factory): JsonResponse
    {
        $token = $tokens->authenticateAccessToken($request->bearerToken());
        if (! $token) {
            return $this->unauthorized();
        }

        $device = Device::find($token->device_id);
        $user = $device ? User::find($device->user_id) : null;
        if (! $device || ! $user) {
            return $this->unauthorized();
        }

        return response()->json($factory->make($user, $device));
    }

    public function keys(): JsonResponse
    {
        $publicKeyPath = (string) config('tiamcp.entitlement_signing_public_key_path');

        return response()->json([
            'keys' => [
                [
                    'key_id' => config('tiamcp.entitlement_signing_key_id'),
                    'algorithm' => config('tiamcp.entitlement_signing_alg'),
                    'status' => 'active',
                    'public_key' => $publicKeyPath !== '' && is_file($publicKeyPath)
                        ? file_get_contents($publicKeyPath)
                        : null,
                ],
            ],
        ]);
    }

    private function unauthorized(): JsonResponse
    {
        return response()->json([
            'error' => [
                'code' => 'unauthorized',
                'message' => 'A valid device access token is required.',
                'request_id' => request()->headers->get('X-Request-Id'),
            ],
        ], 401);
    }
}
