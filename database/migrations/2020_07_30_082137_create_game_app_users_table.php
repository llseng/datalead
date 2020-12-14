<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_app_users', function (Blueprint $table) {
            $table->increments('id');

            $table->string( 'init_id', 40 )->collation('utf8mb4_bin');
            $table->string( 'unique_id', 40 )->nullable()->collation('utf8mb4_bin');
            $table->string( 'reg_ip', 40 )->nullable();
            $table->tinyInteger( 'os' )->unsigned();
            $table->tinyInteger( 'channel' )->unsigned(); //渠道
            $table->date('create_date');
            $table->time('create_time');

            $table->unique( 'init_id', 'init_id' );
            $table->index( 'unique_id', 'unique_id' );
            $table->index( 'channel', 'channel' );
            $table->index( 'create_date', 'create_date' );
            $table->index( 'create_time', 'create_time' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_app_users');
    }
}
