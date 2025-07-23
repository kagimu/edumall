<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:8080', // For Vite (optional if you're using it locally)
        'https://edumall-uganda.netlify.app', // ✅ This is your Netlify frontend
        'https://edumall-admin.up.railway.app', // ✅ This is your Railway backend
        
    ],  
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // ❗ Set to false if you don't use cookies or Laravel Sanctum
];
