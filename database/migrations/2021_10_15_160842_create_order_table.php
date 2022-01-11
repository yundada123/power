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
            $table->string('user_id')->unique()->default('')->comment('用户ID');
            $table->string('orderid')->unique()->default('')->comment('系统订单编号');
            $table->string('p_order_id')->unique()->default('')->comment('供应商订单号');
            $table->string('u_order_id')->unique()->default('')->comment('用户订单编号');
            $table->string('type')->default('')->comment('订单类型');
            $table->string('order_price')->default('')->comment('订单价格');
            $table->string('status')->default('0')->comment('订单状态');
            $table->string('shop_id')->default('')->comment('商品ID');
            $table->string('p_msg')->nullable()->comment('供应商返回消息');
            $table->string('order_chai')->default('0')->comment('订单折扣');
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
