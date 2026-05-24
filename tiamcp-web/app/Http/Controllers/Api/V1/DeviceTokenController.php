<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Services\Devices\DeviceAuthorizationService;
use App\Services\Devices\DeviceTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    public function store(Request $request, DeviceAuthorizationService $authorizations, DeviceTokenService $tokens): JsonResponse
    {
        $validated = $request->validate([
            'device_code' => ['required', 'string', 'max:160'],
        ]);

        $authorization = $authorizations->findByDeviceCode($validated['device_code']);
        if (! $authorization) {
            return $this->error('invalid_device_code', 'The device code is invalid.', 400);
        }

        if ($authorization->isExpired()) {
            $authorization->update(['status' => 'expired']);

            return $this->error('expired_token', 'The device authorization expired.', 400);
        }

        $secondsSinceLastPoll = $authorization->secondsSinceLastPoll();
        if ($secondsSinceLastPoll !== null && $secondsSinceLastPoll < (int) config('tiamcp.device_poll_interval_seconds')) {
            $authorizations->markPolled($authorization);

            return $this->error('slow_down', 'Poll less frequently.', 429);
        }

        $authorizations->markPolled($authorization);

        if ($authorization->status === 'pending') {
            return $this->error('authorization_pending', 'The user has not approved this device yet.', 428);
        }

        $device = Device::find($authorization->device_id);
        if ($authorization->status !== 'approved' || ! $device) {
            return $this->error('access_denied', 'The device authorization was not approved.', 403);
        }

        return response()->json($tokens->issue($device));
    }

    public function refresh(Request $request, DeviceTokenService $tokens): JsonResponse
    {
        $validated = $request->validate([
            'refresh_token' => ['required', 'string', 'max:160'],
        ]);

        $issued = $tokens->refresh($validated['refresh_token']);

        return $issued
            ? response()->json($issued)
            : $this->error('invalid_refresh_token', 'The refresh token is invalid, expired, or revoked.', 401);
    }

    public function revoke(Request $request, DeviceTokenService $tokens): JsonResponse
    {
        $refreshToken = $request->string('refresh_token')->toString();
        $accessToken = $request->bearerToken();

        $revoked = $refreshToken !== ''
            ? $tokens->revokeByRefreshToken($refreshToken)
            : false;

        if (! $revoked && $accessToken) {
            $deviceToken = $tokens->authenticateAccessToken($accessToken);
            if ($deviceToken) {
                $tokens->revoke($deviceToken);
                $revoked = true;
            }
        }

        return $revoked
            ? response()->json(['revoked' => true])
            : $this->error('invalid_token', 'No active device token was found.', 401);
    }

    private function error(string $code, string $message, int $status): JsonResponse
    {
        return response()->json([
            'error' => [
                'code' => $code,
                'message' => $message,
                'request_id' => request()->headers->get('X-Request-Id'),
            ],
        ], $status);
    }
}
