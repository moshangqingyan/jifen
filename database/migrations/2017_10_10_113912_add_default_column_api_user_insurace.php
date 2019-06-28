<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultColumnApiUserInsurace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 指定用户使用的保险公司
        Schema::table('api_user_insurance', function (Blueprint $table) {
            $table->addColumn('boolean', 'default')->default(0);//默认使用的算价器
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_user_insurance', function (Blueprint $table) {
            $table->dropColumn('default');//默认使用的算价器
        });
    }
}
