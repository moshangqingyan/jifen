<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiUserAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // premium_cache添加count字段
        Schema::table('api_user', function (Blueprint $table) {
            $table->addColumn('string', 'province', ['length' => 255])->nullable(); // 省份
            $table->addColumn('string', 'ip', ['length' => 16])->nullable();  // IP
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_user', function (Blueprint $table) {
            $table->dropColumn('province');
            $table->dropColumn('ip');
        });
    }
}
