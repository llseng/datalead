<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGameAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_app_users', function (Blueprint $table) {
            $table->bigInteger('aid')->unsigned(); //广告计划id
            $table->bigInteger('cid')->unsigned(); //广告创意id
            $table->bigInteger('gid')->unsigned(); //广告组id
            $table->integer('site')->unsigned(); //广告投放位置

            $table->index( 'site', 'site' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_app_users', function (Blueprint $table) {
            $table->dropColumn('aid');
            $table->dropColumn('cid');
            $table->dropColumn('gid');
            $table->dropColumn('site');

            $table->dropIndex( 'site' );
        });
    }
}
