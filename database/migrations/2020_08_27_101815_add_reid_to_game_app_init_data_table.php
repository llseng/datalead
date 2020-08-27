<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReidToGameAppInitDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_app_init_data', function (Blueprint $table) {
            $table->string( 'reid', 40 )->nullable()->after("init_id")->collation('utf8mb4_bin');
            $table->index('reid', 'reid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_app_init_data', function (Blueprint $table) {
            $table->dropIndex( "reid" );

            $table->dropColumn( "reid" );
        });
    }
}
