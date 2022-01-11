<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user')->nullable();
            $table->string('pwd')->nullable();
            $table->string('admin_url')->nullable();
            $table->string('api_acco')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_url')->nullable();
            $table->char('status')->default('0')->nullable();
            $table->text('desc')->nullable();
            $table->string('discount')->nullable();
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
        Schema::dropIfExists('channel');
    }
}
