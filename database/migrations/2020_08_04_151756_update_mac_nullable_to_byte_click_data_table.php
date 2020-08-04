<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMacNullableToByteClickDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('byte_click_data', function (Blueprint $table) {
            $table->string('request_id', 100)->nullable()->change(); //请求下发的id
            $table->string('mac', 32)->nullable()->change(); //移动设备mac地址
            $table->string('ip', 40)->nullable()->change(); //媒体投放系统获取的用户终端的公共IP地址
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('byte_click_data', function (Blueprint $table) {
            $table->string('mac', 32)->change(); //移动设备mac地址
            $table->string('ip', 40)->change(); //媒体投放系统获取的用户终端的公共IP地址
        });
    }
}
