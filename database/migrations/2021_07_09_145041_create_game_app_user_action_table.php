<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameAppUserActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_app_user_action', function (Blueprint $table) {
            $table->increments('id');
            $table->string('init_id', 40)->collation('utf8mb4_bin');
            $table->string('type', 20)->collation('utf8mb4_bin');
            $table->string('content', 50)->nullable();
            $table->date('create_date');
            $table->time('create_time');

            $table->index(['init_id', 'type'], 'init_type');
            $table->index('create_date', 'create_date');
            $table->index('create_time', 'create_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_app_user_action');
    }
}
