<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Driver
    |--------------------------------------------------------------------------
    |
    | The Laravel queue API supports a variety of back-ends via an unified
    | API, giving you convenient access to each back-end using the same
    | syntax for each one. Here you may set the default queue driver.
    |
    | Supported: "null", "sync", "database", "beanstalkd",
    |            "sqs", "iron", "redis"
    |
    */

    'default' => env('QUEUE_DRIVER', 'redis'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    */

    'connections' => [

        'redis' => [
            'driver'     => env('QUEUE_DRIVER', 'redis'),
            'connection' => 'queue',
            'queue'      => 'default',
            'expire'     => 86400,
        ],

        'redis_high' => [
            'driver'     => env('QUEUE_DRIVER', 'redis'),
            'connection' => 'queue',
            'queue'      => 'high',
            'expire'     => 86400,
        ],

        'redis_low' => [
            'driver'     => env('QUEUE_DRIVER', 'redis'),
            'connection' => 'queue',
            'queue'      => 'low',
            'expire'     => 86400,
        ],

    ]

];
