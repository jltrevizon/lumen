<?php

return [

    'disks' => [
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_SECRET_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ]
    ]

];