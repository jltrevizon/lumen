<?php

return [
    'default' => 'mysql',
    'migrations' => 'migrations',
    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'mysql2' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'focus_testing',
            'username' => 'homestead',
            'password' => 'secret',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'redis' => [
            'client' => 'predis',
            'default' => [
                'host' => env('REDIS_HOST', '127.0.0.1'),
                'password' => env('REDIS_PASSWORD', null),
                'port' => env('REDIS_PORT', 6379),
                'database' => 0,
            ],
        ],    
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => 'focus_testing', // ':memory:'
            'prefix' => '',
        ],
    ]
];
