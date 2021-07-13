<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameAppSortNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_app_sort_names', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger( 'sup_id' )->default(0)->comment('上级ID');
            $table->unsignedTinyInteger( 'platform_id' )->comment('平台ID');
            $table->unsignedTinyInteger( 'level' )->default(0)->comment('类型级别 0 组, 1 计划, 2 创意');
            $table->unsignedBigInteger( 'sort_id' )->comment('类型ID');
            $table->string( 'sort_name', 256 )->nullable()->comment('类型名称');
            $table->string( 'sup_chain', 32 )->nullable()->comment('父级链');
            $table->timestamp( 'created_at' )->comment('创建时间');

            $table->index(['platform_id', 'level', 'sort_id'], 'p_level_sort');
            $table->index(['sort_id', 'sort_name'], 'sort_id_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_app_sort_names');
    }
}
