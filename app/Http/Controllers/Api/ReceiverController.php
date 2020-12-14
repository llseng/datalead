<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Log;

use App\Logic\AppUsers;
use App\Logic\AppUsersFormat;
use App\Logic\AppCallback;
use App\Logic\AppDataFilter;

//点击监测
use App\Logic\AppClickData as AppClickDataL;
use App\Logic\AppData\Click\ByteData as AppClickByteData;
use App\Logic\AppData\Click\KuaiShouData as AppClickKuaiShouData;
use App\Logic\AppData\Click\TxadData as AppClickTxadData;
use App\Http\Requests\Api\AppClick\Byte as AppClickByteVali;
use App\Http\Requests\Api\AppClick\KuaiShou as AppClickKuaiShouVali;
use App\Http\Requests\Api\AppClick\Txad as AppClickTxadVali;

class ReceiverController extends Controller
{

    public function __construct() {
        $this->middleware( 'gameappid_check' );
    }

    /**
     * 字节广告点击监测
     *
     * @param Request $request
     * @param string $app_id
     * @return json
     */
    public function app_click_byte( Request $request, $app_id ) {
        $req_data = $request->all();
        $vali = new AppClickByteVali; //表单验证
        $valiRes = static::jsonValidateFilter( $vali, $req_data, $valiStatus, ['aid'] );
        if( !$valiStatus ) {
            Log::debug( static::class .': valiFail', $valiRes );
            return \response()->json( $valiRes );
        }
        //点击数据对象
        $AppClickData = new AppClickByteData( $req_data );
        Log::debug( __FUNCTION__. ': unique_id '. $AppClickData->getUniqueId() );

        $AppClickDataL = new AppClickDataL( $app_id );
        $create_status = $AppClickDataL->createByClickData( $AppClickData );

        return \response()->json( static::jsonRes( ) );
    }

    /**
     * 快手广告点击监测
     *
     * @param Request $request
     * @param string $app_id
     * @return json
     */
    public function app_click_kuaishou( Request $request, $app_id ) {
        $req_data = $request->all();
        $vali = new AppClickKuaiShouVali; //表单验证
        $valiRes = static::jsonValidateFilter( $vali, $req_data, $valiStatus, ['aid'] );
        if( !$valiStatus ) {
            Log::debug( static::class .': valiFail', $valiRes );
            return \response()->json( $valiRes );
        }
        //点击数据对象
        $AppClickData = new AppClickKuaiShouData( $req_data );
        Log::debug( __FUNCTION__. ': unique_id '. $AppClickData->getUniqueId() );

        $AppClickDataL = new AppClickDataL( $app_id );
        $create_status = $AppClickDataL->createByClickData( $AppClickData );

        return \response()->json( static::jsonRes( ) );
    }

    /**
     * 腾讯广告点击监测
     *
     * @param Request $request
     * @param string $app_id
     * @return json
     */
    public function app_click_txad( Request $request, $app_id ) {
        $req_data = $request->all();
        $vali = new AppClickTxadVali; //表单验证
        $valiRes = static::jsonValidateFilter( $vali, $req_data, $valiStatus, ['muid'] );
        if( !$valiStatus ) {
            Log::debug( static::class .': valiFail', $valiRes );
            return \response()->json( $valiRes );
        }
        //点击数据对象
        $AppClickData = new AppClickTxadData( $req_data );
        Log::debug( __FUNCTION__. ': unique_id '. $AppClickData->getUniqueId() );

        $AppClickDataL = new AppClickDataL( $app_id );
        $create_status = $AppClickDataL->createByClickData( $AppClickData );

        return \response()->json( ['ret' => 0, 'msg' => ''] );
    }

}
