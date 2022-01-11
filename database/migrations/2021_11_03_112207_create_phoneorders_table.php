<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phoneorders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->default('')->comment('用户');
            $table->string('phone')->default('')->comment('手机号');
            $table->string('orderid')->nullable()->comment('系统订单号');
            $table->string('porderid')->nullable()->comment('渠道订单号');
            $table->string('uorderid')->nullable()->comment('客户订单号');
            $table->string('notfiynum')->default('0')->nullable()->comment('回调次数');
            $table->string('province')->nullable()->comment('省');
            $table->string('city')->nullable()->comment('市');
            $table->string('status')->default('0')->comment('状态');
            $table->string('type')->default('0')->comment('类型0 慢充 1 快充');
            $table->string('source')->default('0')->nullable()->comment('来源 0 平台手动1API');
            $table->string('note')->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phoneorders');
    }
}
