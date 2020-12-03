<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameAppClickDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_app_click_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'unique_id', 40 )->nullable()->collation('utf8mb4_bin')->comment('应用唯一ID');
            $table->unsignedTinyInteger( 'platform_id' )->nullable()->comment('平台ID');
            $table->string( 'click_id', 64 )->nullable()->comment('点击唯一ID');
            $table->unsignedBigInteger( 'aid' )->nullable()->comment('计划ID');
            $table->unsignedBigInteger( 'cid' )->nullable()->comment('创意ID');
            $table->unsignedBigInteger( 'gid' )->nullable()->comment('组ID');
            $table->unsignedBigInteger( 'account_id' )->nullable()->comment('账户ID');
            $table->string( 'imei', 32 )->nullable()->comment('imei_MD5');
            $table->string( 'idfa', 32 )->nullable()->comment('ios_idfa_MD5');
            $table->string( 'androidid', 32 )->nullable()->comment('androidid_MD5');
            $table->string( 'oaid', 32 )->nullable()->comment('oaid_MD5');
            $table->string( 'mac', 32 )->nullable()->comment('mac_upper_MD5'); //大写后MD5
            $table->string( 'ip', 40 )->nullable()->comment('ip');
            $table->unsignedTinyInteger( 'os' )->nullable()->comment('os');
            $table->unsignedBigInteger( 'ts' )->nullable()->comment('毫秒');
            $table->string( 'ua', 512 )->nullable()->comment("user_agent");
            $table->string( 'callback_url', 512 )->nullable()->comment("callback_url");
            $table->string( 'other', 512 )->nullable()->comment("补充数据");
            $table->date( 'create_date' );
            $table->time( 'create_time' );

            $table->index( 'unique_id', 'unique_id' );
            $table->index( [ 'platform_id', 'click_id' ], 'platform_click' );
            $table->index( 'ts', 'ts' );
            $table->index( 'create_date', 'create_date' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_app_click_data');
    }
}
