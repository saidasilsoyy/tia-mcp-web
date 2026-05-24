<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'service' => 'tiamcp-web',
            'version' => config('tiamcp.public_build_version'),
            'environment' => config('tiamcp.deployment_label'),
        ]);
    }
}
