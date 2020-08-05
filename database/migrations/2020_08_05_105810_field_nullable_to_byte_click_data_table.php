<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FieldNullableToByteClickDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('byte_click_data', function (Blueprint $table) {
            $table->string('unique_id', 40)->nullable()->change(); //唯一标识
            $table->unsignedBigInteger('cid')->nullable()->change(); //广告创意id
            $table->unsignedBigInteger('advertiser_id')->nullable()->change(); //广告主id
            $table->unsignedBigInteger('campaign_id')->nullable()->change(); //广告组id
            $table->unsignedInteger('ctype')->nullable()->change(); //创意样式
            $table->unsignedInteger('csite')->nullable()->change(); //广告投放位置
            $table->unsignedBigInteger('ts')->nullable()->change(); //客户端发生广告点击事件的时间，以毫秒为单位时间戳

            $table->text('ua')->nullable()->change(); //用户代理(User Agent)
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
            $table->string('unique_id', 40)->change(); //唯一标识
            $table->unsignedBigInteger('cid')->change(); //广告创意id
            $table->unsignedBigInteger('advertiser_id')->change(); //广告主id
            $table->unsignedBigInteger('campaign_id')->change(); //广告组id
            $table->unsignedInteger('ctype')->change(); //创意样式
            $table->unsignedInteger('csite')->change(); //广告投放位置
            $table->unsignedBigInteger('ts')->change(); //客户端发生广告点击事件的时间，以毫秒为单位时间戳

            $table->string('ua', 100)->nullable()->change(); //用户代理(User Agent)
        });
    }
}
