<?php

return [
    'offline'        => env('ASSETS_OFFLINE', true),
    'enable_version' => env('ASSETS_ENABLE_VERSION', false),
    'version'        => env('ASSETS_VERSION', time()),
    'scripts'        => [
        'modernizr',
        'app',
    ],
    'styles'         => [
        'bootstrap',
    ],
    'resources'      => [
        'scripts' => [],
        'styles'  => [],
    ],
];
