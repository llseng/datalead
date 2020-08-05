<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteSomeFieldToGameAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_app_users', function (Blueprint $table) {
            $table->dropIndex( 'site' );
            $table->dropUnique( 'unique_id' );

            $table->dropColumn('aid');
            $table->dropColumn('cid');
            $table->dropColumn('gid');
            $table->dropColumn('site');

            $table->string( 'reg_ip', 40 )->nullable()->change();

            $table->string( 'unique_id', 40 )->collation('utf8mb4_bin')->nullable()->change();
            $table->index( 'unique_id', 'unique_id' );

            $table->string( 'init_id', 40 )->collation('utf8mb4_bin')->after('id');
            $table->unique( 'init_id', 'init_id' );
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
            $table->dropIndex( 'unique_id' );
            $table->dropUnique( 'init_id' );

            $table->dropColumn( 'init_id' );

            $table->bigInteger('aid')->unsigned()->after('channel'); //广告计划id
            $table->bigInteger('cid')->unsigned()->after('aid'); //广告创意id
            $table->bigInteger('gid')->unsigned()->after('cid'); //广告组id
            $table->integer('site')->unsigned()->after('gid'); //广告投放位置
            
            $table->string( 'reg_ip', 40 )->change();

            $table->string( 'unique_id', 40 )->collation('utf8mb4_bin')->change();
            $table->unique( 'unique_id', 'unique_id' );

            $table->index( 'site', 'site' );
        });
    }
}
