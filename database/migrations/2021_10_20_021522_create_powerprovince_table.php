<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePowerprovinceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('powerprovince', function (Blueprint $table) {
            $table->increments('id');
            $table->string('province_name')->default('')->comment('省份');
            $table->char('status')->default('1')->comment('状态');
            $table->string('power_id')->default('')->comment('省份ID');
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
        Schema::dropIfExists('powerprovince');
    }
}
