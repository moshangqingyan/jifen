<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewPremiumCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 现在的缓存只保存折扣信息，通过VIN码一一对应，不保存任何其他车辆信息了，
        Schema::create('premium_cache', function (Blueprint $table) {
            // 唯一索引 vin码
            $table->string('VIN', 17)->unique();
            // 车型代码(各家保险可能不一样，因为无意义),改成存放别名跟购置价
            $table->string('MODEL_ALIAS')->nullable();
            $table->string('PRICE')->default(0);
            // 车损险保费
            $table->float('TDVI_PREMIUM')->default(0);
            // 商业险折扣
            $table->float('BUSINESS_DISCOUNT', 8, 6)->default(1);
            // 车船税
            $table->float('CAR_BOAT_INSURANCE')->default(0);
            // 交强险直接保存保费,不保存折扣
            $table->integer('MVTALCI_INSURANCE')->default(0);
            // 起保日期，用来判断是否过期
            $table->timestamp('START_DATE')->nullable();
            // 是否已投保
            $table->boolean('IS_REPEAT')->default(false);
            // 缓存创建时间与更新时间
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
        Schema::drop('premium_cache');
    }
}
