<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProxyInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxy_insurance', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proxy_id');                 // 代理服务器id
            $table->string('insurance_id');             // 保险公司id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proxy_insurance');
    }
}
