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
            $table->integer('user_id')->unique()->comment('用户ID');
            $table->string('orderid')->unique()->default('')->comment('系统订单编号');
            $table->string('p_order_id')->default('')->comment('供应商订单号');
            $table->string('u_order_id')->default('')->comment('用户订单编号');
            $table->integer('type')->comment('订单类型');
            $table->string('order_price')->default('')->comment('订单价格');
            $table->integer('order_chai')->default('0')->comment('拆单状态');
            $table->integer('status')->default('0')->comment('订单状态（0 创建订单）');
            $table->integer('shop_id')->comment('商品ID');
            $table->string('p_msg')->nullable()->comment('供应商返回消息');
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
