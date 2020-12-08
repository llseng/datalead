<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdRedundancyInfoToGameAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_app_users', function (Blueprint $table) {
            $table->unsignedInteger( 'click_id' )->nullable()->after( 'init_id' )->comment( '点击id' );
            $table->string( 'callback_url', 512 )->nullable()->after( 'channel' )->comment( '回调地址' );
            $table->unsignedBigInteger( 'cid' )->nullable()->after("channel")->comment('创意ID');
            $table->unsignedBigInteger( 'aid' )->nullable()->after("channel")->comment('计划ID');
            $table->unsignedBigInteger( 'gid' )->nullable()->after("channel")->comment('组ID');
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
            $table->dropColumn( 'click_id' );
            $table->dropColumn( 'aid' );
            $table->dropColumn( 'cid' );
            $table->dropColumn( 'gid' );
            $table->dropColumn( 'callback_url' );
        });
    }
}
