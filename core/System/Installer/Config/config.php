<?php

return [
    'core' => [
        'minPhpVersion' => '7.0.0',
    ],
    'requirements' => [
        'php' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
            'fileinfo',
            'bcmath',
            'Ctype',
            'xml'
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],
    'permissions' => [
        'database/'     => '775',
        'database/migrations/'     => '775',
        'storage/app/'     => '775',
        'storage/app/analytics/'     => '775',
        'storage/app/public/'     => '775',
        'storage/framework/'     => '775',
        'storage/framework/cache/'     => '775',
        'storage/framework/cache/data/'     => '775',
        'storage/framework/sessions/'     => '775',
        'storage/framework/testing'     => '775',
        'storage/framework/views'     => '775',
        'storage/logs/'          => '775',
        'bootstrap/cache/'       => '775',
    ],
    'theme_default'=>'seobin'
];