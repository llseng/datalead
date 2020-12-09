<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Logic;
use App\BaseModel;

use App\Logic\LeadContent as LC;
use App\Logic\AppInitData as AppInitDataL;
use App\Http\Requests\Test as TestVali;

class Test extends Controller
{
    public function index(TestVali $request) {
        
    }
}
