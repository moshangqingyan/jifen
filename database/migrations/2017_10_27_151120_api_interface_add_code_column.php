<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiInterfaceAddCodeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // api_interface添加code字段
        Schema::table('api_interface', function (Blueprint $table) {
            $table->addColumn('string', 'code', ['length' => 255]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_interface', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}
