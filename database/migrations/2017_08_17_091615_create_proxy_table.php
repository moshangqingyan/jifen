<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProxyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');                 // 名称
            $table->string('url')->nullable();      // url地址
            $table->string('ip')->nullable();       // ip地址
            $table->integer('port')->default(80);   // 端口
            $table->integer('status')->default(1);  // 状态
            $table->integer('user_id')->nullable();   // 代理服务器所属api用户
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
        Schema::drop('proxy');
    }
}
