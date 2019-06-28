<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountUseLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_use_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();        // 用户ID
            $table->integer('account_id')->nullable();     // 账号ID
            $table->text('remark')->nullable();            // 使用结果
            $table->timestamp('created_at')->nullable();   // 创建日期
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('account_use_log');
    }
}
