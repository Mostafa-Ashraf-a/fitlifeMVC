<?php
return [

    'defaults' => [
        'guard' => 'manager',
        'passwords' => 'users',
    ],

    // Add Guards
    'guards' => [
        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],
        'user' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'user-api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],
        'manager' => [
            'driver' => 'session',
            'provider' => 'managers',
        ],
    ],

    // Add Provider
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'managers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Manager::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'managers' => [
            'provider' => 'managers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
