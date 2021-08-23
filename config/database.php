<?php

return [
    'default' => 'mysql',
    'migrations' => 'migrations',
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
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => 'focus_testing', // ':memory:'
            'prefix' => '',
        ],
    ]
];
