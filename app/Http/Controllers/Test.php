<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Logic;
use App\BaseModel;

use App\Logic\LeadContent as LC;

class Test extends Controller
{
    public function index() {

        $data = [];
        return \response()->json( static::jsonRes(404, null, $data) );
    }
}
