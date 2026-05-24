<?php

return [
    'api_version' => env('TIAMCP_API_VERSION', 'v1'),
    'deployment_label' => env('TIAMCP_DEPLOYMENT_LABEL', env('APP_ENV', 'local')),
    'public_build_version' => env('APP_VERSION', '0.0.0-local'),
    'support_email' => env('TIAMCP_SUPPORT_EMAIL', 'support@tiamcp.com'),
    'public_api_base_url' => env('TIAMCP_PUBLIC_API_BASE_URL', env('APP_URL', 'http://localhost').'/api/v1'),
    'device_activation_url' => env('TIAMCP_DEVICE_ACTIVATION_URL', env('APP_URL', 'http://localhost').'/device'),
];
