<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Log;

use App\Http\Requests\Api\AppInitData;

class ListenController extends Controller
{
    public function __construct() {
        $this->middleware( 'gameappid_check' );
        //接口日志记录
        Log::info( static::class .': requestUri '. \request()->fullUrl(), \request()->all() );
    }

    public function app_init( Request $request, $app_id ) {
        $req_data = $request->all();
        $valiRes = static::jsonValidate( new AppInitData, $req_data, $valiStatus );
        if( !$valiStatus ) {
            Log::debug( static::class .': valiFail', $valiRes );
            return \response()->json( $valiRes );
        }
     
        return \response()->json( static::jsonRes( ) );
    }
}
