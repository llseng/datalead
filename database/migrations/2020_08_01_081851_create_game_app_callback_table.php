<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameAppCallbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_app_callback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string( 'appid', 20 );
            $table->string( 'url', 512 ); //回调连接
            $table->string( 'query', 512 )->nullable(); //回调数据
            $table->string( 'res', 512 )->nullable(); //响应数据
            $table->tinyInteger('status')->unsigned()->default(0); //状态
            $table->timestamps();

            $table->index( 'appid', 'appid' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_app_callback');
    }
}
