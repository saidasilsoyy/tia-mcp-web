<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class MetaController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'api_version' => config('tiamcp.api_version'),
            'environment' => config('tiamcp.deployment_label'),
            'public_build_version' => config('tiamcp.public_build_version'),
            'urls' => [
                'api' => config('tiamcp.public_api_base_url'),
                'device_activation' => config('tiamcp.device_activation_url'),
            ],
        ]);
    }
}
