<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\BaseModel;
use App\Logic\AppUsers as AppUsersLogic;

class Test extends Controller
{
    public function index() {
        return \response()->json( static::jsonRes(404) );
    }
}
