<?php

return [

    'default' => env('LOG_CHANNEL', 'stack'),

    'channels' => [
        'telegram' => [
            'driver' => 'custom',
            'via' => Logger\TelegramLogger::class,
            'level' => 'debug',
        ],
    ],

];
