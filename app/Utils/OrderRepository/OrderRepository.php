<?php

namespace App\Utils\OrderRepository;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderRepository
 * @package App\Utils\OrderRepository
 */
class OrderRepository
{
    /**
     * @param string $type
     * @return Order|Model|null
     */
    public function findOpenOrderByType(string $type): ?Order
    {
        return Order::query()->where([
            'type' => $type,
            'status' => Order::OPEN_STATUS,
        ])->latest()->first();
    }

    /**
     * @param string $type
     * @return Order|Model
     */
    public function createOrder(string $type): Order
    {
        return Order::query()->create([
            'symbol' => config('binance.symbol'),
            'type' => $type,
            'quantity' => config('binance.quantity'),
            'status' => Order::OPEN_STATUS,
            'entry_time' => Carbon::now(),
        ]);
    }

    /**
     * @param Order $order
     * @return void
     */
    public function closeOrder(Order $order): void
    {
        $order->update([
            'status' => Order::CLOSE_STATUS,
            'exit_time' => Carbon::now(),
        ]);
    }
}
