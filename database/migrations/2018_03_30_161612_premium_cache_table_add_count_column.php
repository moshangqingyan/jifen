<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PremiumCacheTableAddCountColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // premium_cache添加count字段
        Schema::table('premium_cache', function (Blueprint $table) {
            $table->addColumn('smallInteger', 'count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('premium_cache', function (Blueprint $table) {
            $table->dropColumn('count');
        });
    }
}
