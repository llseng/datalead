<?php

namespace App\Http\Controllers\Api;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppSortNames as AppSortNamesL;

class AppLogController extends Controller
{
    public function __construct( ) {
        $this->middleware( 'gameappid_check' );
        $this->middleware( 'api_appLog' );
    }

    public function adinfo( Request $request, $app_id ) {
        return \response()->json( static::jsonRes( 0, null, [], false ) );
    }

    public function adinfo_v2( Request $request, $app_id ) {
        $today = date("Y-m-d");
        $today_stime = \date("H:i:s", time() - 600 );
        $today_etime = \date("H:i:s");

        $start_datetime = $request->input('start_datetime', $today. " ". $today_stime);
        $end_datetime = $request->input('end_datetime', $today. " ". $today_etime);
        $start_time = \strtotime( $start_datetime );
        $end_time = \strtotime( $end_datetime );

        $AppUsersL = new AppUsersL( $app_id );
        $AppUsersM = $AppUsersL->getTableModelObj();

        $start_date = date( "Y-m-d", $start_time );
        $start_dtime = date( "H:i:s", $start_time );
        $end_date = date( "Y-m-d", $end_time );
        $end_dtime = date( "H:i:s", $end_time );

        $date_where = [];
        if( $start_date == $end_date ) {
            $date_where = [
                [ 'create_date', '=', $start_date ],
                [ 'create_time', '>=', $start_dtime ],
                [ 'create_time', '<=', $end_dtime ],
            ];
        }else{
            $date_where = [
                [ 'create_date', '>=', $start_date ],
                [ 'create_date', '<=', $end_date ],
                [ DB::raw( "CONCAT( create_date, ' ', create_time )" ), ">=", $start_datetime ],
                [ DB::raw( "CONCAT( create_date, ' ', create_time )" ), "<=", $end_datetime ],
            ];
        }

        $result = $AppUsersM->select("init_id", "unique_id", "channel", "account_id", "gid", "aid", "cid")->where( $date_where )->get()->toArray();

        return \response()->json( static::jsonRes( 0, null, $result, false ) );
    }

    public function sort_names( Request $request, $app_id ) {
        $AppSortNamesL = new AppSortNamesL( $app_id );
        $result = DB::table( $AppSortNamesL->getTable() )->select([ "platform_id", "level", "sort_id", "sort_name" ])->get()->toArray();

        return \response()->json( static::jsonRes( 0, null, $result, false ) );
    }

}
