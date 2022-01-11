<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditlog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pid')->default('')->comment('授信人');
            $table->string('amount')->default('')->comment('金额');
            $table->string('uid')->default('')->comment('被授信人');
            $table->string('aamount')->default('')->comment('授信前余额');
            $table->string('bamount')->default('')->comment('授信后余额');
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
        Schema::dropIfExists('creditlog');
    }
}
