<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Logic;
use App\BaseModel;

class Test extends Controller
{
    public function index() {
        $data = [
            'byte_click' => Logic\AppByteClickData::getUrlQuery(),
            'byte_show' => Logic\AppByteShowData::getUrlQuery(),
        ];
        return \response()->json( static::jsonRes(404, null, $data) );
    }
}
