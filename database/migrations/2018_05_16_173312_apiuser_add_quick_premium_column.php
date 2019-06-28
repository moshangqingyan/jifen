<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiuserAddQuickPremiumColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_user', function (Blueprint $table) {
            $table->addColumn('tinyInteger', 'quick_premium')->default(0); // 算价是否优先走快速算价，默认否
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
            $table->dropColumn('quick_premium');
        });
    }
}
