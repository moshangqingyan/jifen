<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');             // 客户名
            $table->string('login_id');             // 用户名
            $table->string('password');             // 密码
            $table->integer('status');               // 状态
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
        Schema::drop('api_user');
    }
}
