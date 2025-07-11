<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Add your API and CSRF paths
    'allowed_methods' => ['*'], // Allow all HTTP methods
    'allowed_origins' => ['http://localhost:8080', 'https://edumall-uganda.netlify.app'], // Your frontend's origin
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // For cookies or authentication
];
