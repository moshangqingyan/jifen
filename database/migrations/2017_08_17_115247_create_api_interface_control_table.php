<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiInterfaceControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 控制到保险公司接口的流量
        Schema::create('api_interface_control', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interface_id');             // 接口id
            $table->integer('proxy_id');                 // 代理服务器
            $table->integer('insurance_id');             // 保险公司
            $table->integer('max_count_day')->default(0);            // 每日请求最大流量限额
            $table->integer('max_rate')->default(0);                 // 每分钟请求最大流量限额
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
        Schema::drop('api_interface_control');
    }
}
