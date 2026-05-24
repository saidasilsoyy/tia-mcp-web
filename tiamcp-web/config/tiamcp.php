<?php

return [
    'api_version' => env('TIAMCP_API_VERSION', 'v1'),
    'deployment_label' => env('TIAMCP_DEPLOYMENT_LABEL', env('APP_ENV', 'local')),
    'public_build_version' => env('APP_VERSION', '0.0.0-local'),
    'support_email' => env('TIAMCP_SUPPORT_EMAIL', 'support@tiamcp.com'),
    'public_api_base_url' => env('TIAMCP_PUBLIC_API_BASE_URL', env('APP_URL', 'http://localhost').'/api/v1'),
    'device_activation_url' => env('TIAMCP_DEVICE_ACTIVATION_URL', env('APP_URL', 'http://localhost').'/device'),
    'device_authorization_expires_minutes' => (int) env('DEVICE_AUTHORIZATION_EXPIRES_MINUTES', 10),
    'device_poll_interval_seconds' => (int) env('DEVICE_POLL_INTERVAL_SECONDS', 5),
    'device_access_token_ttl_minutes' => (int) env('DEVICE_ACCESS_TOKEN_TTL_MINUTES', 60),
    'device_refresh_token_ttl_days' => (int) env('DEVICE_REFRESH_TOKEN_TTL_DAYS', 90),
    'entitlement_signing_key_id' => env('ENTITLEMENT_SIGNING_KEY_ID', 'local-dev'),
    'entitlement_signing_alg' => env('ENTITLEMENT_SIGNING_ALG', 'HS256'),
    'entitlement_signing_secret' => env('ENTITLEMENT_SIGNING_SECRET', env('APP_KEY', '')),
    'entitlement_signing_private_key_path' => env('ENTITLEMENT_SIGNING_PRIVATE_KEY_PATH'),
    'entitlement_signing_public_key_path' => env('ENTITLEMENT_SIGNING_PUBLIC_KEY_PATH'),
    'entitlement_offline_window_minutes' => (int) env('ENTITLEMENT_OFFLINE_WINDOW_MINUTES', 1440),
];
