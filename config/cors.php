<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines which cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    */

    // Paths to apply CORS to
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Allowed HTTP methods
    'allowed_methods' => ['*'],

    // Allowed origins (cast to string first, then explode to array to avoid errors)
    'allowed_origins' => explode(',', (string) env('CORS_ALLOWED_ORIGINS', '')),

    // Allowed origin patterns (regex)
    'allowed_origins_patterns' => [],

    // Allowed headers
    'allowed_headers' => ['*'],

    // Exposed headers to frontend
    'exposed_headers' => ['Authorization'],

    // How long the results of a preflight request can be cached (seconds)
    'max_age' => 0,

    // Whether to allow credentials (cookies, Authorization headers)
    'supports_credentials' => true,

];
?>

