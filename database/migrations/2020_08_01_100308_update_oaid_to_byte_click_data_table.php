<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOaidToByteClickDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('byte_click_data', function (Blueprint $table) {
            $table->string('oaid', 40)->nullable()->change(); //Android Q及更高版本的设备号
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('byte_click_data', function (Blueprint $table) {
            $table->string('oaid', 32)->nullable()->change(); //Android Q及更高版本的设备号
        });
    }
}
