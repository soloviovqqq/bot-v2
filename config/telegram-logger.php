<?php

return [
    'token' => env('TELEGRAM_BOT_TOKEN'),
    'chat_id' => env('TELEGRAM_LOGGER_CHAT_ID'),
    'template' => env('TELEGRAM_LOGGER_TEMPLATE', 'laravel-telegram-logging::minimal'),
];
