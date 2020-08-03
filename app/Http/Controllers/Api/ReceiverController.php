<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ByteClickData;
use App\Http\Requests\Api\ByteShowData;

use Log;

use App\Logic\AppUsers;
use App\Logic\AppUsersUid;
use App\Logic\AppUsersFormat;
use App\Logic\AppCallback;
use App\Logic\AppDataFilter;

use App\Logic\AppByteShowData;
use App\Logic\AppByteClickData;

class ReceiverController extends Controller
{

    public function __construct() {
        $this->middleware( 'gameappid_check' );
        //调试接口日志
        Log::info( static::class .': requestUri '. request()->fullUrl() );
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
            Log::debug( static::class .': valiFail', $valiRes );
            return \response()->json( $valiRes );
        }
        //获取唯一ID
        $unique_id = AppUsersUid::fromByteClickData( $req_data );
        $req_data['unique_id'] = $unique_id;
        Log::debug( static::class .': unique_id '. $unique_id );

        //应用用户逻辑
        $AppUsers = new AppUsers( $app_id );
        $user_data;
        $create_user_status = $AppUsers->create( AppUsersFormat::fromByteClickData( $req_data ), $user_data );
        //字节点击数据逻辑
        $AppByteClickData = new AppByteClickData( $app_id );
        $create_data_status = $AppByteClickData->create( $req_data );
        //转化事件回调
        if( empty( $user_data ) ) {
            !empty( $req_data['callback_url'] ) && AppCallback::create( $app_id, $req_data['callback_url'], ['event_type' => 0] ); //激活事件
        }else{
            if( 
                !empty( $req_data['callback_url'] ) 
                && $user_data->create_date == date( "Y-m-d", time() - 86400 ) 
            ) {
                AppCallback::create( $app_id, $req_data['callback_url'], ['event_type' => 6] ); //次留事件
            }
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
            Log::debug( static::class .': valiFail ', $valiRes );
            return \response()->json( $valiRes );
        }

        $filter_data = AppDataFilter::filterByteData( $req_data );
        $replace_data = AppDataFilter::filterByteData( $req_data, "" );

        //获取唯一ID
        $unique_id = AppUsersUid::fromBtyeShowData( $replace_data );
        $filter_data['unique_id'] = $unique_id;
        Log::debug( static::class .': unique_id '. $unique_id );

        //字节展示数据逻辑
        $AppByteShowData = new AppByteShowData( $app_id );
        $AppByteShowData->create( $filter_data );

        return \response()->json( static::jsonRes( ) );
    }
}
