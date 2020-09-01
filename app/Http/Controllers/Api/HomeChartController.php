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

use App\Logic\AppUsersFormat as AppUsersFormatL;

use App\Http\Requests\Api\HomeChart as HomeChartVali;

class HomeChartController extends Controller
{

    static public $channel_list = [
        "自然量" => 1,
        "字节跳动" => 2,
    ];

    public function __construct() {
        // $this->middleware('auth');
        $this->middleware('gameappid_check');
        //接口日志记录
        Log::info( static::class .': requestUri '. \request()->fullUrl(), \request()->all() );
    }

    /**
     * 字节广告点击数据
     *
     * @param HomeChartVali $request
     * @param string $app_id
     * @return jsonRes
     */
    public function byte_click( HomeChartVali $request, $app_id ) {
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
     * @param HomeChartVali $request
     * @param string $app_id
     * @return jsonRes
     */
    public function app_init( HomeChartVali $request, $app_id ) {
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
     * @param HomeChartVali $request
     * @param string $app_id
     * @return jsonRes
     */
    public function activation( HomeChartVali $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppUsersL( $app_id );

        //渠道列表
        foreach (static::$channel_list as $channel_name => $channel_id) {
            
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
     * @param HomeChartVali $request
     * @param string $app_id
     * @return jsonRes
     */
    public function active( HomeChartVali $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppInitDataL( $app_id );
        $AppUsersL = new AppUsersL( $app_id );

        //渠道列表
        foreach (static::$channel_list as $channel_name => $channel_id) {
            
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
     * @param HomeChartVali $request
     * @param string $app_id
     * @return jsonRes
     */
    public function oneRetained( HomeChartVali $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppInitDataL( $app_id );
        $AppUsersL = new AppUsersL( $app_id );
        
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

        //数据三维数组
        $resultArr = [];
        foreach ($result as $value) {
            $value = (array)$value;
            if( !isset( $resultArr[ $value['date'] ] ) ) $resultArr[ $value['date'] ] = [];
            $resultArr[ $value['date'] ][ $value['channel'] ] = $value['num'];
        }
        
        //渠道列表
        foreach (static::$channel_list as $channel_name => $channel_id) {

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

    /**
     * 渠道数据
     *
     * @param HomeChartVali $request
     * @param string $app_id
     * @return jsonRes
     */
    public function channel( HomeChartVali $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppUsersL( $app_id );
        
        $where = [];

        if( $date_end == $date_start ) {
            $where[] = ["create_date", "=", $date_end];
            
        }else{
            $where[] = ["create_date", ">=", $date_start];
            $where[] = ["create_date", "<=", $date_end];
        }
        $result = $Logic->getTableModelObj()->select( DB::raw("channel, COUNT( id ) as num") )->where( $where )->groupBy("channel")->pluck("num", "channel");

        //渠道
        $type_list = array_flip( static::$channel_list );
        $res_result = [];
        
        foreach ($result as $key => $val) {
            $res_li = [];
            $res_li['name'] = isset( $type_list[ $key ] )? $type_list[ $key ]: $key;
            $res_li['value'] = $val;
            $res_result[] = $res_li;
        }
        //填充无数据类型
        foreach ($type_list as $key => $val) {
            if( !isset( $result[ $key ] ) ) {
                $res_li = [];
                $res_li['name'] = $val;
                $res_li['value'] = 0;
                $res_result[] = $res_li;
            }
        }

        $resDate["渠道"] = $res_result;

        return \response()->json( static::jsonRes( 0, null, $resDate, false ) );
    }

    /**
     * 字节跳动点击样式数据
     *
     * @param HomeChartVali $request
     * @param string $app_id
     * @return jsonRes
     */
    public function click_type( HomeChartVali $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppByteClickDataL( $app_id );
        
        $where = [];

        if( $date_end == $date_start ) {
            $where[] = ["create_date", "=", $date_end];
            
        }else{
            $where[] = ["create_date", ">=", $date_start];
            $where[] = ["create_date", "<=", $date_end];
        }
        $result = $Logic->getTableModelObj()->select( DB::raw("ctype, COUNT( id ) as num") )->where( $where )->groupBy("ctype")->pluck("num", "ctype");
        //字节点击样式列表
        $type_list = AppUsersFormatL::$type_list['byte'];
        $res_result = [];

        foreach ($result as $key => $val) {
            $res_li = [];
            $res_li['name'] = isset( $type_list[ $key ] )? $type_list[ $key ]: $key;
            $res_li['value'] = $val;
            $res_result[] = $res_li;
        }
        //填充无数据类型
        foreach ($type_list as $key => $val) {
            if( !isset( $result[ $key ] ) ) {
                $res_li = [];
                $res_li['name'] = $val;
                $res_li['value'] = 0;
                $res_result[] = $res_li;
            }
        }

        $resDate["点击样式"] = $res_result;

        return \response()->json( static::jsonRes( 0, null, $resDate, false ) );
    }

    /**
     * 字节跳动点击投放数据
     *
     * @param HomeChartVali $request
     * @param string $app_id
     * @return jsonRes
     */
    public function click_site( HomeChartVali $request, $app_id ) {
        $today = date("Y-m-d");
        $date_start = $request->input('date_start', $today);
        $date_end = $request->input('date_end', $today);
        $date_start_time = \strtotime( $date_start );
        $date_end_time = \strtotime( $date_end ) + (86400 - 1);
        $resDate = [];

        $Logic = new AppByteClickDataL( $app_id );
        
        $where = [];

        if( $date_end == $date_start ) {
            $where[] = ["create_date", "=", $date_end];
            
        }else{
            $where[] = ["create_date", ">=", $date_start];
            $where[] = ["create_date", "<=", $date_end];
        }
        $result = $Logic->getTableModelObj()->select( DB::raw("csite, COUNT( id ) as num") )->where( $where )->groupBy("csite")->pluck("num", "csite");
        //字节投放列表
        $type_list = AppUsersFormatL::$site_list['byte'];
        $res_result = [];

        foreach ($result as $key => $val) {
            $res_li = [];
            $res_li['name'] = isset( $type_list[ $key ] )? $type_list[ $key ]: $key;
            $res_li['value'] = $val;
            $res_result[] = $res_li;
        }
        //填充无数据类型
        foreach ($type_list as $key => $val) {
            if( !isset( $result[ $key ] ) ) {
                $res_li = [];
                $res_li['name'] = $val;
                $res_li['value'] = 0;
                $res_result[] = $res_li;
            }
        }

        $resDate["点击投放"] = $res_result;

        return \response()->json( static::jsonRes( 0, null, $resDate, false ) );
    }

}
