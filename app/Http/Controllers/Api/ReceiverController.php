<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ByteClickData;
use App\Http\Requests\Api\ByteShowData;

class ReceiverController extends Controller
{
    public function __construct() {
        $this->middleware( 'gameappid_check' );
    }

    /**
     * 字节跳动点击监测
     *
     * @param ByteClickData $request
     * @param string $app_id
     * @return json
     */
    public function byte_click( Request $request, $app_id ) {
        $req_data = $request->all();
        $valiRes = static::jsonValidate( new ByteClickData, $req_data, $valiStatus );
        if( !$valiStatus ) {
            return \response()->json( $valiRes );
        }

        return \response()->json( static::jsonRes( ) );
    }

    /**
     * 字节跳动展示监测
     *
     * @param ByteShowData $request
     * @param string $app_id
     * @return json
     */
    public function byte_show( Request $request, $app_id ) {
        $req_data = $request->all();
        $valiRes = static::jsonValidate( new ByteShowData, $req_data, $valiStatus );
        if( !$valiStatus ) {
            return \response()->json( $valiRes );
        }

        return \response()->json( static::jsonRes( ) );
    }
}
