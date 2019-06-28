<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoInfoTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 车辆信息
        Schema::create('auto_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vin', 17)->index();
            $table->text('info');
            $table->integer('flag')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('auto_info');
    }
}
