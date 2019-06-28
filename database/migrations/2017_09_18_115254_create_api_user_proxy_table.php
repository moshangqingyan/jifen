<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiUserProxyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 指定用户使用代理的代理服务器
        Schema::create('api_user_proxy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');              // 用户id
            $table->integer('proxy_id');             // 代理服务器id
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
        Schema::drop('api_user_proxy');
    }
}
