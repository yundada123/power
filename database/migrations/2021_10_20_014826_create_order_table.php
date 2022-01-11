<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->default('')->comment('用户ID');
            $table->string('orderid')->unique()->default('')->comment('系统订单编号');
            $table->string('p_order_id')->nullable()->comment('供应商订单号');
            $table->string('u_order_id')->default('')->comment('用户订单编号');
            $table->string('type')->default('')->comment('订单类型');
            $table->string('order_price')->default('')->comment('订单价格');
            $table->string('notify')->nullable()->comment('回调地址');
            $table->string('kk_amount')->default('')->comment('扣款金额');
            $table->string('status')->default('0')->comment('订单状态');
            $table->string('shop_id')->default('')->comment('商品ID');
            $table->string('notify_status')->default('0')->nullable()->comment('回调状态');
            $table->text('notify_msg')->nullable()->comment('回调响应');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
