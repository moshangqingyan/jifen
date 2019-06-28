<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiUserInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 指定用户使用的保险公司
        Schema::create('api_user_insurance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');              // 用户id
            $table->integer('insurance_id');         // 保险公司id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('api_user_insurance');
    }
}
