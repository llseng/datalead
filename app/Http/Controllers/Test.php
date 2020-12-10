<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\BaseModel;

use App\Logic\LeadContent as LC;

use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppInitData as AppInitDataL;
use App\Logic\AppClickData as AppClickDataL;

use App\Http\Requests\Test as TestVali;

class Test extends Controller
{
    public function index(TestVali $request) {

    }
}
