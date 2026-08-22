<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To restrict to production domain, change 'allowed_origins' to:
    |   ['https://yourdomain.com']
    |
    */

    'paths' => ['api/*', 'up'],

    'allowed_methods' => ['*'],

    // Fail-closed: if FRONTEND_URL is not set, no origin is allowed.
    // Set FRONTEND_URL in .env to your production frontend URL (e.g. https://yourdomain.com).
    'allowed_origins' => array_filter([env('FRONTEND_URL')]),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
