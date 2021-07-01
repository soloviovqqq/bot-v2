<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddOrderIdToOrdersTable
 */
class AddOrderIdToOrdersTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('opening_order_id')->after('id')->nullable();
            $table->string('closing_order_id')->after('opening_order_id')->nullable();
            $table->double('pln')->after('exit_time')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('opening_order_id');
            $table->dropColumn('closing_order_id');
            $table->dropColumn('pln');
        });
    }
}
