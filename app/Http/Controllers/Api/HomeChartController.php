<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Log;

use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppInitData as AppInitDataL;
use App\Logic\AppByteShowData as AppByteShowDataL;
use App\Logic\AppByteClickData as AppByteClickDataL;

class HomeChartController extends Controller
{
    public function __construct() {
        // $this->middleware('auth');
        $this->middleware('gameappid_check');
        //接口日志记录
        Log::info( static::class .': requestUri '. \request()->fullUrl(), \request()->all() );
    }

    /**
     * 字节广告点击数据
     *
     * @param Request $request
     * @param string $app_id
     * @return jsonRes
     */
    public function byte_click( Request $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppByteClickDataL( $app_id );
        
        $where = [];
        $date_key_format = "";
        $date_key_inctime = 0;

        if( $date_end == $date_start ) {
            $where[] = ["create_date", "=", $date_end];
            
            $result = $Logic->getTableModelObj()->select( DB::raw( "LEFT( create_time, 2 ) as date, COUNT( id ) as num") )->where( $where )->groupBy("date")->pluck( "num", "date" );
            
            $date_key_format = "H";
            $date_key_inctime = 3600;
        }else{
            $where[] = ["create_date", ">=", $date_start];
            $where[] = ["create_date", "<=", $date_end];
            
            $result = $Logic->getTableModelObj()->select( DB::raw( "create_date as date, COUNT( id ) as num" ) )->where( $where )->groupBy("date")->pluck( "num", "date" );

            $date_key_format = "Y-m-d";
            $date_key_inctime = 86400;
        }

        $res_result = [];
        $date_time = $date_start_time;
        while ( $date_time < $date_end_time ) {
            $date_key = date( $date_key_format, $date_time );
            $res_result_li = [];
            $res_result_li['date'] = $date_key;
            $res_result_li['num'] = isset($result[$date_key])? $result[$date_key]: 0;
            $res_result[] = $res_result_li;

            $date_time += $date_key_inctime;
        }

        $resDate["广告点击"] = $res_result;

        return \response()->json( static::jsonRes( 0, null, $resDate, false ) );
    }

    /**
     * 应用启动数据
     *
     * @param Request $request
     * @param string $app_id
     * @return jsonRes
     */
    public function app_init( Request $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppInitDataL( $app_id );
        
        $where = [];
        $date_key_format = "";
        $date_key_inctime = 0;

        if( $date_end == $date_start ) {
            $where[] = ["create_date", "=", $date_end];
            
            $result = $Logic->getTableModelObj()->select( DB::raw( "LEFT( create_time, 2 ) as date, COUNT( id ) as num") )->where( $where )->groupBy("date")->pluck( "num", "date" );
            
            $date_key_format = "H";
            $date_key_inctime = 3600;
        }else{
            $where[] = ["create_date", ">=", $date_start];
            $where[] = ["create_date", "<=", $date_end];
            
            $result = $Logic->getTableModelObj()->select( DB::raw( "create_date as date, COUNT( id ) as num" ) )->where( $where )->groupBy("date")->pluck( "num", "date" );

            $date_key_format = "Y-m-d";
            $date_key_inctime = 86400;
        }

        $res_result = [];
        $date_time = $date_start_time;
        while ( $date_time < $date_end_time ) {
            $date_key = date( $date_key_format, $date_time );
            $res_result_li = [];
            $res_result_li['date'] = $date_key;
            $res_result_li['num'] = isset($result[$date_key])? $result[$date_key]: 0;
            $res_result[] = $res_result_li;

            $date_time += $date_key_inctime;
        }

        $resDate["启动"] = $res_result;

        return \response()->json( static::jsonRes( 0, null, $resDate, false ) );
    }

    /**
     * 激活数据
     *
     * @param Request $request
     * @param string $app_id
     * @return jsonRes
     */
    public function activation( Request $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppUsersL( $app_id );

        //渠道列表
        $channel_list = [
            "自然量" => 1,
            "字节跳动" => 2,
        ];

        foreach ($channel_list as $channel_name => $channel_id) {
            
            $where = [];
            $where = ["channel" => $channel_id];
            $date_key_format = "";
            $date_key_inctime = 0;

            if( $date_end == $date_start ) {
                $where[] = ["create_date", "=", $date_end];
                
                $result = $Logic->getTableModelObj()->select( DB::raw( "LEFT( create_time, 2 ) as date, COUNT( id ) as num") )->where( $where )->groupBy("date")->pluck( "num", "date" );
                
                $date_key_format = "H";
                $date_key_inctime = 3600;
            }else{
                $where[] = ["create_date", ">=", $date_start];
                $where[] = ["create_date", "<=", $date_end];
                
                $result = $Logic->getTableModelObj()->select( DB::raw( "create_date as date, COUNT( id ) as num" ) )->where( $where )->groupBy("date")->pluck( "num", "date" );

                $date_key_format = "Y-m-d";
                $date_key_inctime = 86400;
            }

            $res_result = [];
            $date_time = $date_start_time;
            while ( $date_time < $date_end_time ) {
                $date_key = date( $date_key_format, $date_time );
                $res_result_li = [];
                $res_result_li['date'] = $date_key;
                $res_result_li['num'] = isset($result[$date_key])? $result[$date_key]: 0;
                $res_result[] = $res_result_li;

                $date_time += $date_key_inctime;
            }

            $resDate[ $channel_name ] = $res_result;
        
        }

        return \response()->json( static::jsonRes( 0, null, $resDate, false ) );
    }

    /**
     * 活跃数据
     *
     * @param Request $request
     * @param string $app_id
     * @return jsonRes
     */
    public function active( Request $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppInitDataL( $app_id );
        $AppUsersL = new AppUsersL( $app_id );

        //渠道列表
        $channel_list = [
            "自然量" => 1,
            "字节跳动" => 2,
        ];

        foreach ($channel_list as $channel_name => $channel_id) {
            
            $where = [];
            $select = "";
            $where = [$AppUsersL->getTable(). ".channel" => $channel_id];
            $date_key_format = "";
            $date_key_inctime = 0;
    
            if( $date_end == $date_start ) {
                $where[] = [$Logic->getTable().".create_date", "=", $date_end];
                $select = DB::raw( "LEFT( ".$Logic->getTable().".create_time, 2 ) as date, COUNT( DISTINCT ".$Logic->getTable().".init_id ) as num");
                
                $date_key_format = "H";
                $date_key_inctime = 3600;
            }else{
                $where[] = [$Logic->getTable().".create_date", ">=", $date_start];
                $where[] = [$Logic->getTable().".create_date", "<=", $date_end];
                $select = DB::raw( $Logic->getTable(). ".create_date as date, COUNT( DISTINCT ".$Logic->getTable().".init_id ) as num" );
    
                $date_key_format = "Y-m-d";
                $date_key_inctime = 86400;
            }
            $result = $Logic->getTableModelObj()->select( $select )->join( $AppUsersL->getTable(), $AppUsersL->getTable(). ".init_id", "=", $Logic->getTable(). ".init_id" )->where( $where )->groupBy("date")->pluck( "num", "date" );
    
            $res_result = [];
            $date_time = $date_start_time;
            while ( $date_time < $date_end_time ) {
                $date_key = date( $date_key_format, $date_time );
                $res_result_li = [];
                $res_result_li['date'] = $date_key;
                $res_result_li['num'] = isset($result[$date_key])? $result[$date_key]: 0;
                $res_result[] = $res_result_li;
    
                $date_time += $date_key_inctime;
            }
    
            $resDate[ $channel_name ] = $res_result;
            
        }

        return \response()->json( static::jsonRes( 0, null, $resDate, false ) );
    }

    /**
     * 次留数据
     *
     * @param Request $request
     * @param string $app_id
     * @return jsonRes
     */
    public function oneRetained( Request $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppInitDataL( $app_id );
        $AppUsersL = new AppUsersL( $app_id );
        /**
         * 自然量
         */
        $where = [];
        $select = "";
        $date_key_format = "Y-m-d";
        $date_key_inctime = 86400;
        //启动日志子查询(去除每日重复)
        if( $date_end == $date_start ) {
            $where[] = ["create_date", "=", $date_end];
        }else{
            $where[] = ["create_date", ">=", $date_start];
            $where[] = ["create_date", "<=", $date_end];
        }
        $initSubSelect = DB::raw( "create_date as date, init_id" );
        $initSub = $Logic->getTableModelObj()->select( $initSubSelect )->where( $where )->groupBy("date")->groupBy("init_id");
        //渠道每日次留
        $initsAs = "inits"; //启动日志表别名
        $usersAs = "users"; //用户表别名
        $select = DB::raw( $initsAs.".date, ". $usersAs. ".channel, sum( if( DATEDIFF( ".$initsAs.".date, ".$usersAs.".create_date ) = 1, 1, 0 ) ) num" );
        $result = DB::table( DB::raw( "(". $initSub->toSql() .") as ".$initsAs ) )->mergeBindings( $initSub->getQuery() )->select( $select )->join( DB::raw( $AppUsersL->getTable(). " as ".$usersAs), "inits.init_id", "=", $usersAs.".init_id" )->groupBy($usersAs.".channel")->groupBy($initsAs.".date")->get()->toArray();
        //渠道列表
        $channel_list = [
            "自然量" => 1,
            "字节跳动" => 2,
        ];
        //数据三维数组
        $resultArr = [];
        foreach ($result as $value) {
            $value = (array)$value;
            if( !isset( $resultArr[ $value['date'] ] ) ) $resultArr[ $value['date'] ] = [];
            $resultArr[ $value['date'] ][ $value['channel'] ] = $value['num'];
        }
        
        foreach ($channel_list as $channel_name => $channel_id) {

            $res_result = [];
            $date_time = $date_start_time;
            while ( $date_time < $date_end_time ) {
                $date_key = date( $date_key_format, $date_time );
                $res_result_li = [];
                $res_result_li['date'] = $date_key;
                $res_result_li['num'] = isset($resultArr[$date_key][$channel_id])? $resultArr[$date_key][$channel_id]: 0;
                $res_result[] = $res_result_li;

                $date_time += $date_key_inctime;
            }

            $resDate[ $channel_name ] = $res_result;
        }

        return \response()->json( static::jsonRes( 0, null, $resDate, false ) );
    }

}
