<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_account', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('insurance_id');   // 保险公司id
            $table->text('account');         // 账号内容
            $table->integer('status')->default(1);  // 账号状态
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
        Schema::drop('insurance_account');
    }
}
