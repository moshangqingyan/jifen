<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePremiumCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('premium_cache');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('premium_cache', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('vin');
            $table->string('insurance'); // 算价器代码
            $table->float('business_discount')->default(1); // 商业险折扣
            $table->float('mvtalci_discount')->default(1); // 交强险折扣
            $table->text('content')->nullable(); // 算价内容
            $table->timestamp('start_date')->nullable(); // 起保日期
            $table->timestamp('expired_at')->nullable();// 过期时间
            $table->timestamps();
        });
    }
}
