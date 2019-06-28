<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 算价器账号表增加`使用的代理服务器proxy`字段
 * Class InsuranceAcountsAddProxyColumn
 */
class InsuranceAcountAddProxyColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insurance_account', function (Blueprint $table) {
            $table->addColumn('integer', 'proxy_id')->nullable(); // 使用的代理服务器ID
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insurance_account', function (Blueprint $table) {
            $table->dropColumn('proxy_id');
        });
    }
}
