<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\BaseModel;

class Test extends Controller
{
    public function index() {
        
        dump( DB::statement( "create table test_table like game_app" ) );
        dump( DB::statement( "drop table test_table" ) );
    }
}
