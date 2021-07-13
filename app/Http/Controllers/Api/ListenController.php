<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Log;

use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppInitData as AppInitDataL;
use App\Logic\AppDataFilter as AppDataFilterL;
use App\Logic\AppUserAction as AppUserActionL;
use App\Logic\AppUsersFormat as AppUsersFormatL;

use App\Http\Requests\Api\AppInitData;
use App\Http\Requests\Api\AppUserAction;

class ListenController extends Controller
{
    public function __construct() {
        $this->middleware( 'gameappid_check' );
    }

    public function app_init( Request $request, $app_id ) {
        $req_data = $request->all();
        
        $valiRes = static::jsonValidateFilter( new AppInitData, $req_data, $valiStatus );
        if( !$valiStatus ) {
            Log::debug( static::class .': valiFail', $valiRes );
            return \response()->json( $valiRes );
        }

        !isset( $req_data['os'] ) && $req_data['os'] = 0;
        empty( $req_data['ua'] ) && $req_data['ua'] = $request->header( 'user-agent' );
        empty( $req_data['ip'] ) && $req_data['ip'] = $request->getClientIp( );
        if( \strlen( $req_data['ip'] ) > 20 ) {
            $req_data['ipv6'] = $req_data['ip'];
            $req_data['ip'] = null;
        }
        if( empty( $req_data['ts'] ) ) {
            $request_time = $request->server( 'REQUEST_TIME_FLOAT' )?: time();
            $req_data['ts'] = \round( $request_time * 1000 );
        }

        $filter_data = AppDataFilterL::filter( $req_data );

        $init_id = AppInitDataL::InitId( $filter_data );
        $filter_data['init_id'] = $init_id;
        Log::debug( static::class .': init_id ' .$init_id );

        $AppInitDataL = new AppInitDataL( $app_id );
        $init_data_create_status = $AppInitDataL->create( $filter_data );

        $user;
        $AppUsersL = new AppUsersL( $app_id );
        $create_user_status = $AppUsersL->only_create( AppUsersFormatL::fromInitData( $filter_data ), $user );

        return \response()->json( static::jsonRes( ) );
    }

    public function app_action( Request $request, $app_id ) {
        $req_data = $request->all();
        
        $valiRes = static::jsonValidate( new AppUserAction, $req_data, $valiStatus );
        if( !$valiStatus ) {
            Log::debug( static::class .': valiFail', $valiRes );
            return \response()->json( $valiRes );
        }

        $AppUserActionL = new AppUserActionL( $app_id );
        $create_status = $AppUserActionL->create( $req_data );
        if(!$create_status) {
            Log::debug( static::class .': create', $req_data );
            return \response()->json( static::jsonRes( 500, 'Record Fail' ) );
        }

        return \response()->json( static::jsonRes( ) );
    }
}
