<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Devices\DeviceAuthorizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceAuthorizationController extends Controller
{
    public function store(Request $request, DeviceAuthorizationService $authorizations): JsonResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:120'],
            'app_version' => ['nullable', 'string', 'max:80'],
            'platform' => ['nullable', 'string', 'max:80'],
            'machine_fingerprint' => ['nullable', 'string', 'max:512'],
        ]);

        return response()->json($authorizations->create($validated, $request), 201);
    }
}
