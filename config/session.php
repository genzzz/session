<?php

use Genzzz\Helpers\Str;

global $wpdb;

return [
    'driver' => env('SESSION_DRIVER', 'file'),
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'file' => [
        'path' => path('storage/sessions')
    ],
    'database' => [
        'connection' => env('SESSION_CONNECTION', $wpdb),
        'table' => 'sessions',
        'model' => Genzzz\Session\Handlers\Database\Models\WP_Model::class
    ],
    'probability' => [2, 100],
    'cookie' => [
        'name' => env('SESSION_COOKIE',Str::slug(env('APP_NAME', 'genzzz'), '_').'_session'),
        'path' => '/',
        'domain' => env('SESSION_DOMAIN', null),
        'secure' => env('SESSION_SECURE_COOKIE', false),
        'httponly' => true,
        'samesite' => null
    ]
];