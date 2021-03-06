<?php

namespace App\Utils\OrderService;

use App\Models\Order;
use Lin\Binance\BinanceFuture;

/**
 * Class OrderService
 * @package App\Utils\OrderService
 */
class OrderService
{
    /**
     * @var BinanceFuture
     */
    private $binance;

    /**
     * OrderService constructor.
     */
    public function __construct()
    {
        $this->binance = new BinanceFuture(config('binance.key'), config('binance.secret'));
    }

    /**
     * @param Order $order
     */
    public function openOrder(Order $order): void
    {
        $binanceOrder = $this->binance->trade()->postOrder([
            'symbol' => $order->symbol,
            'side' => $order->type,
            'type' => 'MARKET',
            'quantity' => $order->quantity,
        ]);
        $order->update([
            'opening_order_id' => $binanceOrder['orderId'],
        ]);
    }

    /**
     * @param Order $order
     */
    public function closeOrder(Order $order): void
    {
        $binanceOrder = $this->binance->trade()->postOrder([
            'symbol' => $order->symbol,
            'side' => $order->type === Order::SELL_TYPE ? Order::BUY_TYPE : Order::SELL_TYPE,
            'type' => 'MARKET',
            'quantity' => $order->quantity,
        ]);

        $order->update([
            'closing_order_id' => $binanceOrder['orderId'],
        ]);
    }
}
