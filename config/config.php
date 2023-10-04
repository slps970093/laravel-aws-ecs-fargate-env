<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'enabled' => env('AWS_CODEDEPLOY_EVENT_HOOK_ENABLED', false),

    // lambda 用戶認證
    'hook' => [
        'auth'  => false,
        'token' => ''
    ],

    'listens' => [],
];