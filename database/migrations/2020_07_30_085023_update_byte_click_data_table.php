<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateByteClickDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('byte_click_data', function (Blueprint $table) {
            $table->string('idfa', 32)->nullable()->after('imei'); //IOS 6+的设备id字段，32位
            $table->string('unique_id', 40)->after('id'); //唯一标识

            $table->index('unique_id', 'unique_id');
            $table->dropIndex('androidid');

            $table->unsignedBigInteger('convert_id')->nullable()->change(); //转化id
            $table->string('request_id', 40)->nullable()->change(); //请求下发的id
            $table->string('imei', 32)->nullable()->change(); //安卓的设备 ID 的 md5 摘要
            $table->string('androidid', 32)->nullable()->change(); //安卓id原值的md5 摘要
            $table->string('oaid', 32)->nullable()->change(); //Android Q及更高版本的设备号
            $table->string('ua', 100)->nullable()->change(); //用户代理(User Agent)
            $table->string('callback_param', 200)->nullable()->change(); //一些跟广告信息相关的回调参数，内容是一个加密字符串，在调用事件回传接口的时候会用到
            $table->string('callback_url', 300)->nullable()->change(); //直接把调用事件回传接口的url生成出来，广告主可以直接使用
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
            $table->dropIndex('unique_id');

            $table->dropColumn('idfa');
            $table->dropColumn('unique_id');
        });
    }
}
