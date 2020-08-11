<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameAppInitDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_app_init_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'init_id', 40 )->collation('utf8mb4_bin');
            $table->string('imei', 32)->nullable(); //安卓的设备 ID
            $table->string('imei2', 32)->nullable(); //安卓的设备 ID
            $table->string('meid', 32)->nullable(); //移动终端标识号
            $table->string('deviceId', 32)->nullable(); //手机设备的串号
            $table->string('idfa', 64)->nullable(); //iOS独有的广告标识符
            $table->string('androidid', 64)->nullable(); //安卓id原值
            $table->string('oaid', 64)->nullable(); //Android Q及更高版本的设备号
            $table->unsignedTinyInteger('os')->nullable(); //操作系统平台
            $table->string('mac', 40)->nullable(); //移动设备mac地址
            $table->string('serial', 32)->nullable(); //Serial Number 串号
            $table->string('manufacturer', 32)->nullable(); //制造商
            $table->string('model', 32)->nullable(); //型号
            $table->string('brand', 32)->nullable(); //品牌
            $table->string('device', 32)->nullable(); //设备名
            $table->string('ip', 20)->nullable(); //用户终端的公共IP地址
            $table->string('ipv6', 45)->nullable(); //用户终端的公共IPv6地址
            $table->text('ua')->nullable(); //用户代理(User Agent)
            $table->unsignedBigInteger('ts')->nullable();
            $table->date('create_date'); //创建日期
            $table->time('create_time'); //创建时间

            $table->index('create_date', 'create_date');
            $table->index('create_time', 'create_time');
            $table->index('init_id', 'init_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_app_init_data');
    }
}
