<?php

return [
    'default'     => env('QUEUE_DRIVER', 'sync'),

    'connections' => [
        'sync'     => [
            'driver' => 'sync',
        ],
        'database' => [
            'driver' => 'database',
            'table'  => 'jobs',
            'queue'  => 'default',
            'expire' => 60,
        ]
    ],

    'failed' => [
        'database' => 'sqlite',
        'table'    => 'failed_jobs',
    ],

];
