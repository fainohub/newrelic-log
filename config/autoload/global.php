<?php

return [
    'debug' => true,
    'whoops' => [
        'json_exceptions' => [
            'display'    => true,
            'show_trace' => true,
            'ajax_only'  => true,
        ],
    ],
    'app_url' => getenv('APP_URL'),
    'bugsnag' => [
        'key' => getenv('BUGSNAG_KEY'),
        'notify' => ['prod', 'dev', 'stage']
    ],
    'redis' => [
        'host' => getenv('REDIS_HOST'),
        'port' => getenv('REDIS_PORT'),
    ],
    'crm360' => [
        'http' => [
            'base_uri' => getenv('APP_CRM360_URL') . getenv('APP_CRM360_VERSION'),
            'connect_timeout' => getenv('APP_CRM360_TIMEOUT'),
            'auth' => [
                getenv('APP_CRM360_USER'), getenv('APP_CRM360_PASSWORD')
            ],
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]
    ],
];
