<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyorderlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('myorderlist', function (Blueprint $table) {
            $table->increments('id');
            $table->string('orderid')->default('')->comment('订单号');
            $table->string('province_name')->default('')->comment('省份');
            $table->string('acco')->default('')->comment('商户');
            $table->string('amount')->default('')->comment('金额');
            $table->string('kk_amount')->default('')->comment('扣款金额');
            $table->string('status')->default('0')->comment('状态');
            $table->string('type')->default('1')->comment('类型');
            $table->string('msg')->nullable()->comment('原因');
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
        Schema::dropIfExists('myorderlist');
    }
}
