<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');                 // 名称
            $table->string('code');                 // 英文简写（代码）
            $table->string('province');             // 省份
            $table->string('url');                  // url地址
            $table->text('account_column');         // 账号字段信息
            $table->integer('status');               // 状态
            $table->string('remark')->nullable();   // 备注信息
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
        Schema::drop('insurance');
    }
}
