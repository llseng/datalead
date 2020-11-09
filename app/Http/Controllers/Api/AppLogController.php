<?php

namespace App\Http\Controllers\Api;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppByteClickData as AppByteClickDataL;

class AppLogController extends Controller
{
    public function __construct( ) {
        $this->middleware( 'gameappid_check' );
        $this->middleware( 'api_appLog' );
        //接口日志记录
        Log::info( static::class .': requestUri '. \request()->fullUrl(), \request()->all() );
    }

    public function adinfo( Request $request, $app_id ) {
        $today = date("Y-m-d");
        $today_stime = \date("H:i:s", time() - 600 );
        $today_etime = \date("H:i:s");

        $start_datetime = $request->input('start_datetime', $today. " ". $today_stime);
        $end_datetime = $request->input('end_datetime', $today. " ". $today_etime);
        $start_time = \strtotime( $start_datetime );
        $end_time = \strtotime( $end_datetime );

        $AppUsersL = new AppUsersL( $app_id );
        $AppByteClickDataL = new AppByteClickDataL( $app_id );
        $AppUsersM = $AppUsersL->getTableModelObj();
        $AppByteClickDataM = $AppByteClickDataL->getTableModelObj();

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

        $userSub = $AppUsersM->newQuery();
        $userSub->select("init_id", "unique_id", "channel"/*, DB::raw("CONCAT( create_date, ' ', create_time ) as `time`")*/)->where( $date_where );
        
        $time_limit = 360 * 60;
        $max_start_time = $start_time - $time_limit;
        $max_start_date = date( 'Y-m-d', $max_start_time );
        $max_start_dtime = date( 'H:i:s', $max_start_time );
        $max_start_datetime = date( 'Y-m-d H:i:s', $max_start_time );

        $max_date_where = [];
        if( $max_start_date == $end_date ) {
            $max_date_where = [
                [ 'create_date', '=', $max_start_date ],
                [ 'create_time', '>=', $max_start_dtime ],
                [ 'create_time', '<=', $end_dtime ],
            ];
        }else{
            $max_date_where = [
                [ 'create_date', '>=', $max_start_date ],
                [ 'create_date', '<=', $end_date ],
                [ DB::raw( "CONCAT( create_date, ' ', create_time )" ), ">=", $max_start_datetime ],
                [ DB::raw( "CONCAT( create_date, ' ', create_time )" ), "<=", $end_datetime ],
            ];
        }

        $dataIdWhereSub = $AppByteClickDataM->newQuery();
        $dataIdWhereSub->select( DB::raw("min( `id` ) min_id") )->where( $max_date_where )->groupBy("unique_id");

        $dataSub = $AppByteClickDataM->select( "unique_id", "aid", "cid", DB::raw("`campaign_id` gid"), "ctype", "csite")->whereIn("id", $dataIdWhereSub);

        $M = DB::table( DB::raw( "(". $userSub->toSql(). ") as `u`" ) )->mergeBindings( $userSub->getQuery() )->select( "u.init_id", "u.channel", /*"u.time",*/ "d.*" )->leftJoin( DB::raw("( ". $dataSub->toSql(). " ) as d" ), "u.unique_id", "=", "d.unique_id" )->mergeBindings( $dataSub->getQuery() )/*->whereNotNull( "d.unique_id" )*/->limit( 5000 );

        $result = $M->get()->toArray();

        return \response()->json( static::jsonRes( 0, null, $result, false ) );
    }

}
