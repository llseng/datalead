<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeHeadToGameAppCallbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_app_callback', function (Blueprint $table) {
            $table->string( 'url', 512 )->change(); //回调连接
            $table->string( 'query', 512 )->nullable()->change(); //回调数据
            $table->string( 'res', 512 )->nullable()->change(); //响应数据
            $table->unsignedTinyInteger( 'type' )->default(0)
            ->after("url")->comment('类型');
            $table->string( 'head', 512 )->nullable()
            ->after("url")->comment('请求头');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_app_callback', function (Blueprint $table) {
            $table->text( 'url' )->change(); //回调连接
            $table->text( 'query' )->nullable()->change(); //回调数据
            $table->text( 'res' )->nullable()->change(); //响应数据
            $table->dropColumn('type');
            $table->dropColumn('head');
        });
    }
}
