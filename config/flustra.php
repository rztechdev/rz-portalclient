<?php

return [
    'api_url' => env('FLUSTRA_API_URL', 'https://wa.flustra.id/api/v1/messages/text'),
    'api_key' => env('FLUSTRA_API_KEY', ''),
    'admin_phones' => array_values(array_filter(array_map('trim', explode(',', env('FLUSTRA_ADMIN_PHONES', env('FLUSTRA_ADMIN_PHONE', '085808749131,082116200363')))))),
    'admin_notification_email' => env('ADMIN_NOTIFICATION_EMAIL', 'rzsupportidn@gmail.com'),
    'internal_api_secret' => env('INTERNAL_API_SECRET', 'rz_portal_sync_secret_key_2026'),
];
