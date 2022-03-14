<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameAppConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_app_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'app_id', 20 )->comment( '应用id' );
            $table->string( 'name', 32 )->comment( 'key' );
            $table->text( 'data' )->comment( 'value' );
            $table->string( 'sort', 32 )->nullable()->comment( '分类' );
            $table->string( 'intro' )->nullable()->comment( '简介' );
            $table->timestamps();

            $table->unique( ['app_id', 'name'], 'uk_app_conf_key' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_app_configs');
    }
}
