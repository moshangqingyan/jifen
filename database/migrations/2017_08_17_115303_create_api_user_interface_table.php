<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiUserInterfaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 控制每个用户的接口流量
        Schema::create('api_user_interface', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');                  // 用户id
            $table->integer('interface_id');             // 接口id
            $table->integer('max_count_day')->nullable();            // 每日请求最大流量限额
            $table->integer('max_rate')->nullable();                 // 每分钟请求最大流量限额
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
        Schema::drop('api_user_interface');
    }
}
