<?php

return [
    'auth' => [
        'basic' => [
            'username' => 'elastic',
            'password' => env('ELASTIC_PASSWORD'),
        ],
    ],
    'log_hosts' => env('ELASTIC_SEARCH_LOG_HOSTS'),
];
