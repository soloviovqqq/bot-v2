<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Lin\Binance\BinanceFuture;
use Laravel\Lumen\Routing\Controller as BaseController;
use Telegram\Bot\Api;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    /**
     * @var BinanceFuture
     */
    private $binance;
    /**
     * @var Api
     */
    private $telegram;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->binance = new BinanceFuture(config('binance.key'), config('binance.secret'));
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    /**
     * @return void
     */
    public function account(): void
    {
        $account = $this->binance->user()->getAccount();

        $message = "*SELL* trade opened:\n" .
            'Entry time: ' . Carbon::now() . "\n";

        $this->telegram->sendMessage([
            'chat_id' => '-556908913',
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);

        $message = "*SELL* trade closed:\n" .
            'Entry time: ' . Carbon::now()->subYear() . "\n" .
            'Exit time: ' . Carbon::now() . "\n" .
            'Total wallet balance: ' . $account['totalWalletBalance'] . "\n";

        $this->telegram->sendMessage([
            'chat_id' => '-556908913',
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);

        dd(
            config('binance.symbol'),
            config('binance.quantity'),
            $account
        );
    }

    /**
     * @return JsonResponse
     */
    public function buy(): JsonResponse
    {
        $this->binance->trade()->postOrder([
            'symbol' => config('binance.symbol'),
            'side' => 'BUY',
            'type' => 'MARKET',
            'quantity' => config('binance.quantity'),
        ]);
//        $this->binance->trade()->postOrder([
//            'symbol' => 'ETHUSDT',
//            'side' => 'SELL',
//            'type' => 'STOP_MARKET',
//            'closePosition' => 'TRUE',
//            'stopPrice' => 1000,
//        ]);

        return response()->json();
    }

    /**
     * @return JsonResponse
     */
    public function sell(): JsonResponse
    {
        $this->binance->trade()->postOrder([
            'symbol' => config('binance.symbol'),
            'side' => 'SELL',
            'type' => 'MARKET',
            'quantity' => config('binance.quantity'),
        ]);
//        $this->binance->trade()->postOrder([
//            'symbol' => 'ETHUSDT',
//            'side' => 'BUY',
//            'type' => 'STOP_MARKET',
//            'closePosition' => 'TRUE',
//            'stopPrice' => 3000,
//        ]);

        return response()->json();
    }
}
