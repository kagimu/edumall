<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://192.168.147.241:8080',
        'http://localhost:8080', // For Vite (optional if you're using it locally)
        'https://edumall-uganda.netlify.app', // ✅ This is your Netlify frontend
    ],
    'allowed_origins_patterns' => [
        '/^https?:\/\/([a-z0-9-]+\.)?edumall-uganda\.app$/',
    ],
    'allowed_headers'   => ['*'],
    'exposed_headers'   => [],
    'max_age' => 86400,
    'supports_credentials' => true, // ❗ Set to false if you don't use cookies or Laravel Sanctum
];
