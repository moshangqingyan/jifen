<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_content', function (Blueprint $table) {
            $table->increments('id');
            $table->text('premium_result')->nullable();
            $table->string('owner')->nullable();        // 车主名称
            $table->string('license_no')->nullable();   // 车牌号码
            $table->string('mobile')->nullable();       // 车主电话号码
            $table->string('user_line')->nullable();    // 坐席工号
            $table->string('custom_name')->nullable();  // 客户名称
            $table->string('custom_content')->nullable(); // 坐席自定义信息
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
        Schema::drop('sms_content');
    }
}
