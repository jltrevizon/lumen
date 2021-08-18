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
        'mysql1' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'focus_testing',
            'username' => 'homestead',
            'password' => 'secret',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ]
];
