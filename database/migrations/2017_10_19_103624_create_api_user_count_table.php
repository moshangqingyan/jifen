<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiUserCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户请求接口统计
        Schema::create('api_user_count', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');        // 用户id
            $table->date('date');              // 日
            $table->string('premium')->nullable();         // 算价统计
            $table->string('vehicle_info')->nullable();    // 车辆信息统计
            $table->string('depreciation')->nullable();    // 折旧价统计
            $table->string('renewal')->nullable();         // 续保统计
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('api_user_count');
    }
}
