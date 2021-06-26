<?php

namespace App\Http\Controllers;

use JsonException;
use App\Models\Order;
use Lin\Binance\BinanceFuture;
use Illuminate\Http\JsonResponse;
use App\Utils\OrderService\OrderService;
use App\Utils\OrderRepository\OrderRepository;
use App\Utils\TelegramService\TelegramService;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var TelegramService
     */
    private $telegramService;

    /**
     * Controller constructor.
     * @param OrderRepository $orderRepository
     * @param OrderService $orderService
     * @param TelegramService $telegramService
     */
    public function __construct(
        OrderRepository $orderRepository,
        OrderService $orderService,
        TelegramService $telegramService
    )
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->telegramService = $telegramService;
    }

    /**
     * @return void
     */
    public function account()
    {
        $binance = new BinanceFuture(config('binance.key'), config('binance.secret'));
        $account = $binance->user()->getAccount();

        dd(
            route('account'),
            config('binance.symbol'),
            config('binance.quantity'),
            $account,
        );
    }

    /**
     * @return JsonResponse
     * @throws JsonException
     * @throws TelegramSDKException
     */
    public function buy(): JsonResponse
    {
        $this->closeOpenedOrder(Order::SELL_TYPE);
        $order = $this->orderRepository->createOrder(Order::BUY_TYPE);
//        $this->orderService->openOrder($order);
        $this->telegramService->sendOpenOrderMessage($order);

        return response()->json();
    }

    /**
     * @return JsonResponse
     * @throws JsonException
     * @throws TelegramSDKException
     */
    public function sell(): JsonResponse
    {
        $this->closeOpenedOrder(Order::BUY_TYPE);
        $order = $this->orderRepository->createOrder(Order::SELL_TYPE);
//        $this->orderService->openOrder($order);
        $this->telegramService->sendOpenOrderMessage($order);

        return response()->json();
    }

    /**
     * @param string $type
     * @throws TelegramSDKException
     * @throws JsonException
     */
    private function closeOpenedOrder(string $type): void
    {
        $openOrder = $this->orderRepository->findOpenOrderByType($type);

        if ($openOrder) {
//            $this->orderService->closeOrder($openOrder);
            $this->orderRepository->closeOrder($openOrder);
            $this->telegramService->sendCloseOrderMessage($openOrder);
        }
    }
}
