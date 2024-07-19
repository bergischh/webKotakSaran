<?php
return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'api'),
        'password' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'jwt' => [
            'driver' => 'jwt',
            'provider' => 'users',
            'ttl' => env('JWT_TTL', 604800)
        ],
    ],
];