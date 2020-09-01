<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Logic;
use App\BaseModel;

use App\Logic\LeadContent as LC;
use App\Logic\AppByteClickData as AppByteClickDataL;

class Test extends Controller
{
    public function index() {
        DB::connection()->enableQueryLog();//开启执行日志

        $AppByteClickDataL = new AppByteClickDataL( "tests" );
        $AppByteClickDataM = $AppByteClickDataL->getTableModelObj();

        $start_date = "2020-08-31";
        $start_datetime = "22:30:06";
        $first_time = \time() - 360 * 60;
        $first_date = date( 'Y-m-d', $first_time );
        $first_datetime = date( 'H:i:s', $first_time );

        $byte_click_data_where = [];
        if( $start_date == $first_date ) {
            $byte_click_data_where = [
                [ 'create_date', '=', $start_date ],
                [ 'create_time', '>=', $start_datetime ],
                [ 'create_time', '<=', $first_datetime ],
            ];
        }else{
            $byte_click_data_where = [
                [ 'create_date', '>=', $start_date ],
                [ 'create_date', '<=', $first_date ],
                [ DB::raw( "CONCAT( create_date, ' ', create_time )"), ">=", $start_date. " ". $start_datetime ],
                [ DB::raw( "CONCAT( create_date, ' ', create_time )"), "<=", $first_date. " ". $first_datetime ],
            ];
        }
        $byte_click_data = $AppByteClickDataM->select("id", "unique_id", "imei", "idfa", "androidid", "oaid", "os", "mac", "ip", "ua", "callback_url")->where( $byte_click_data_where )->orderBy('id', 'desc')->limit( 1000 )->get()->toArray();

        dump( DB::getQueryLog() );

        $data = [];
        return \response()->json( static::jsonRes(404, null, $data) );
    }
}
