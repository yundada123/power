<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsrecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assetsrecord', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->unique()->default('')->comment('用户ID');
            $table->string('before')->default('')->comment('之前金额');
            $table->string('balance')->default('')->comment('金额');
            $table->string('after')->default('')->comment('之后金额');
            $table->char('type')->comment('1=授信，2 扣款');
            $table->string('aid')->unique()->default('')->comment('消费源');
            $table->string('orderid')->unique()->default('')->comment('订单号');
            $table->char('xftype')->comment('商品类型对应商品分类ID');
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
        Schema::dropIfExists('assetsrecord');
    }
}
