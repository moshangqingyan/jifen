<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsuranceAccountAddTypeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // insurance_account添加账号类型字段type：1 apiuser提交的账号，2 系统添加的账号
        // user_id提交账号的用户
        Schema::table('insurance_account', function (Blueprint $table) {
            $table->addColumn('integer', 'type')->default(1);
            $table->addColumn('integer', 'user_id')->nullable();
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
            $table->dropColumn('type');
        });
    }
}
