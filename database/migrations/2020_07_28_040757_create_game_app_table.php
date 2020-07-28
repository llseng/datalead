<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_app', function (Blueprint $table) {
            $table->string('id', 20)->collation('utf8mb4_bin');
            $table->string('name', 20); //名字
            $table->string('desc', 100); //介绍
            $table->string('download_url', 300); //下载地址
            $table->timestamps();
            $table->primary('id'); //设置主键
            $table->comment = "游戏应用";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_app');
    }
}
