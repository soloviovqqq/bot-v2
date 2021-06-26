<?php


namespace App\Utils\TelegramService;

use JsonException;
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
            '-------------------------------------------------';

        $this->telegram->sendMessage([
            'chat_id' => config('telegram.chatId'),
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);
    }

    /**
     * @param Order $order
     * @throws JsonException
     * @throws TelegramSDKException
     */
    public function sendCloseOrderMessage(Order $order): void
    {
        $message = "*" . $order->type . "* trade closed:\n" .
            'Entry time: ' . $order->entry_time . "\n" .
            'Exit time: ' . $order->exit_time . "\n" .
            '-------------------------------------------------';

        $this->telegram->sendMessage([
            'chat_id' => config('telegram.chatId'),
            'text' => $message,
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'Total wallet balance',
                            'url' => 'https://bot-v2.soloviovqqq.fun',
//                            'url' => route('account'),
                        ]
                    ],
                ]
            ], JSON_THROW_ON_ERROR),
        ]);
    }
}
