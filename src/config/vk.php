<?php

return [
    'secrets' => [
        'callback' => env('VK_SECRET_KEY_CALLBACK'),
        'group'    => env('VK_SECRET_KEY_GROUP'),
        'init'     => env('VK_SECRET_INIT_KEY'),
    ],
    'api'     => [
        'version' => env('VK_API_VERSION'),
    ],
];
