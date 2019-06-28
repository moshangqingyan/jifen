<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteAutoInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 接口不保存任何车辆信息了
        Schema::drop('auto_info');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 车辆信息
        Schema::create('auto_info', function (Blueprint $table) {
            $table->increments('id');
            // 车辆类型
            $table->string('license_no', 7); // 车牌号码
            $table->string('license_type')->default('SMALL_CAR'); // 车牌类型
            $table->string('use_character')->default('NON_OPERATING_PRIVATE'); // 车辆使用性质
            $table->string('vehicle_type')->default('PASSENGER_CAR'); // 车辆种类
            $table->date('enroll_date'); // 注册日期
            // 车主信息
            $table->string('owner', 40); // 车主
            $table->string('identify_type')->default('IDENTITY_CARD'); // 证件类型
            $table->string('identify_no'); // 证件号码
            $table->string('mobile', 11);   // 电话号码
            $table->string('address', 255)->nullable();
            // 车辆参数
            $table->string('vin_no');   // 车架号
            $table->string('engine_no'); // 发动机号码
            $table->float('buying_price'); // 购置价
            $table->string('model');    // 车辆品牌型号
            $table->string('model_code'); // 车型代码
            $table->smallInteger('seats')->nullable(); // 座位
            $table->string('kerb_mass')->nullable(); // 整备质量
            $table->string('total_mass')->nullable(); // 总质量
            $table->string('load_mass')->nullable(); // 排气量
            $table->string('tow_mass')->nullable(); // 核载质量
            $table->string('engine')->nullable();// 排气量
            $table->string('power')->nullable(); // 功率
            $table->string('body_size')->nullable(); // 车身尺寸
            $table->string('body_color')->nullable(); // 车身颜色
            $table->string('origin')->default('DOMESTIC'); // 产地
            $table->string('energy_type')->default('FUEL'); // 能源类型
            //  操作信息
            $table->integer('create_userid');
            $table->timestamps();
        });
    }
}
