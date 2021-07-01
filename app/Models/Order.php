<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App\Models
 *
 * @property string $opening_order_id
 * @property string $closing_order_id
 * @property string $symbol
 * @property string $type
 * @property float $quantity
 * @property int $status
 * @property Carbon|null $entry_time
 * @property Carbon|null $exit_time
 */
class Order extends Model
{
    public const SELL_TYPE = 'SELL';
    public const BUY_TYPE = 'BUY';

    public const OPEN_STATUS = 1;
    public const CLOSE_STATUS = 2;

    /**
     * @var array
     */
    protected $fillable = [
        'opening_order_id',
        'closing_order_id',
        'symbol',
        'type',
        'quantity',
        'status',
        'entry_time',
        'exit_time',
        'pln',
    ];

    protected $perPage = 10;
}
