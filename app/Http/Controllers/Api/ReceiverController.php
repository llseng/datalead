<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ByteClickData;
use App\Http\Requests\Api\ByteShowData;

class ReceiverController extends Controller
{
    /**
     * 字节跳动点击监测
     *
     * @param ByteClickData $request
     * @param string $app_id
     * @return json
     */
    public function byte_click( Request $request, $app_id ) {
        return \response()->json( static::jsonRes( 0, null ) );
    }

    /**
     * 字节跳动展示监测
     *
     * @param ByteShowData $request
     * @param string $app_id
     * @return json
     */
    public function byte_show( Request $request, $app_id ) {
        return \response()->json( static::jsonRes( 0, null ) );
    }
}
