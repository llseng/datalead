<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCallbackToByteClickDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('byte_click_data', function (Blueprint $table) {
            //使用text类型
            $table->text('callback_param')->nullable()->change(); //一些跟广告信息相关的回调参数，内容是一个加密字符串，在调用事件回传接口的时候会用到
            $table->text('callback_url')->nullable()->change(); //直接把调用事件回传接口的url生成出来，广告主可以直接使用
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
            $table->string('callback_param', 200)->nullable()->change(); //一些跟广告信息相关的回调参数，内容是一个加密字符串，在调用事件回传接口的时候会用到
            $table->string('callback_url', 300)->nullable()->change(); //直接把调用事件回传接口的url生成出来，广告主可以直接使用
        });
    }
}
