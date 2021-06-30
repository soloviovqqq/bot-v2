<?php

namespace App\Utils\TelegramService;

use App\Models\Order;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class TelegramService
 * @package App\Utils\TelegramService
 */
class TelegramService
{
    /**
     * @var Api
     */
    private $telegram;

    /**
     * TelegramService constructor.
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * @param Order $order
     * @throws TelegramSDKException
     */
    public function sendOpenOrderMessage(Order $order): void
    {
        $message = "*" . $order->type . "* trade opened:\n" .
            'Entry time: ' . $order->entry_time . "\n" .
            '---------------------------------';

        $this->telegram->sendMessage([
            'chat_id' => config('telegram.chatId'),
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);
    }

    /**
     * @param Order $order
     * @throws TelegramSDKException
     */
    public function sendCloseOrderMessage(Order $order): void
    {
        $message = "*" . $order->type . "* trade closed:\n" .
            'Entry time: ' . $order->entry_time . "\n" .
            'Exit time: ' . $order->exit_time . "\n" .
            '---------------------------------';

        $this->telegram->sendMessage([
            'chat_id' => config('telegram.chatId'),
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);
    }
}
