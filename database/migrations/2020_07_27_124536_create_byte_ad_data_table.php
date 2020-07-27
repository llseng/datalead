<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateByteAdDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('byte_ad_data', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('aid'); //广告计划id
            $table->unsignedBigInteger('cid'); //广告创意id
            $table->unsignedBigInteger('advertiser_id'); //广告主id
            $table->unsignedBigInteger('campaign_id'); //广告组id
            $table->unsignedBigInteger('convert_id'); //转化id
            $table->unsignedInteger('ctype'); //创意样式
            $table->unsignedInteger('csite'); //广告投放位置
            $table->string('imei', 32); //安卓的设备 ID 的 md5 摘要
            $table->string('androidid', 32); //安卓id原值的md5 摘要
            $table->string('oaid', 32); //Android Q及更高版本的设备号
            $table->unsignedTinyInteger('os'); //操作系统平台
            $table->string('mac', 32); //移动设备mac地址
            $table->string('ip', 40); //媒体投放系统获取的用户终端的公共IP地址
            $table->unsignedBigInteger('ts'); //客户端发生广告点击事件的时间，以毫秒为单位时间戳
            $table->string('callback_param', 200); //一些跟广告信息相关的回调参数，内容是一个加密字符串，在调用事件回传接口的时候会用到
            $table->string('callback_url', 300); //直接把调用事件回传接口的url生成出来，广告主可以直接使用
            $table->date('create_date'); //创建日期
            $table->index('create_date', 'create_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('byte_ad_data');
    }
}
