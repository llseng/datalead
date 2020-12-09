<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppInitData as AppInitDataL;
use App\Logic\AppClickData as AppClickDataL;

use App\Logic\AppUsersFormat as AppUsersFormatL;

use App\Logic\LeadContent as LC;

class LogStreamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('gameapp_check');
    }

    public function inits( ) {
        $view_data = ['view_title'=>'应用启动'];
        $view_data['left_nav_name'] = "log_stream";
        $view_data['left_nav_li_name'] = "log_stream_inits";

        $os_list = array_flip( AppUsersFormatL::$os_list );
        //设备信息
        $app_info_list = [
            "reid" => "REID",
            "imei" => "IMEI",
            "idfa" => "IDFA",
            "androidid" => "ANDROIDID",
            "oaid" => "OAID",
            "mac" => "MAC",
            "ip" => "IP",
        ];
        //设备附加信息
        $app_info_other_list = [
            "ip" => "IP",
            "ipv6" => "IPV6",
            "ua" => "User-Agent",
            "ts" => "毫秒时间搓",
        ];
        //设备信息键
        $app_info_all_keys = \array_keys( \array_merge( $app_info_other_list, $app_info_list ) );

        $init_id = \request()->input( "init_id" );
        $reid = \request()->input( "reid" );
        $date = \request()->input( "date" );
        $os = \request()->input( "os" );
        $app_info_key = \request()->input( "app_info_key" );
        $app_info_val = \request()->input( "app_info_val" );

        $app_id = GameAppController::getSessKey();

        $Logic = new AppInitDataL( $app_id );
        $Model = $Logic->getTableModelObj();

        $where = [];
        !\is_null( $init_id ) && $where[] = [ "init_id", "=", $init_id ];
        !\is_null( $date ) && $where[] = [ "create_date", "=", $date ];
        !\is_null( $os ) && $where[] = [ "os", "=", $os ];
        if( 
            !\is_null( $app_info_key ) 
            && \in_array( $app_info_key, \array_keys( $app_info_list ) ) 
            && !\is_null( $app_info_val ) 
        ) {
            $where[] = [ $app_info_key, "=", $app_info_val ];
        }else{
            $app_info_key = $app_info_val = null;
        }

        $columns = ["id", "init_id", "reid", "imei", "idfa", "androidid", "oaid", "mac", "ip", "ipv6", "ua", "ts", "os", "create_date", "create_time"];
        $list = $Model->select( $columns )->where( $where )->orderBy( 'id', 'desc' )->paginate( 20 );
        $list->withPath( \url()->full() );

        $LCTable = new LC\Table( );
        //设置分页数据
        $LCTable->setPaginator( $list );

        $init_id_form = new LC\TableFormInput( "启动ID", "init_id", $init_id );
        $date_form = new LC\TableFormInput( "日期", "date", $date );
        $date_form->inputType( "date" );
        $os_form = new LC\TableFormSelect( "选择机型", "os", $os );
        $os_form->setOptions( $os_list );
        $app_info_key_form = new LC\TableFormSelect( "选择设备信息", "app_info_key", $app_info_key );
        $app_info_key_form->setOptions( $app_info_list );
        $app_info_val_form = new LC\TableFormInput( "输入设备信息值", "app_info_val", $app_info_val );

        $LCTable->setRows( [
            $init_id_form,
            $date_form,
            $os_form,
            $app_info_key_form,
            $app_info_val_form
        ] );

        $id_line = new LC\TableInfo( "#", "id" );
        $init_id_line = new LC\TableInfo( "启动ID", "init_id" );
        $content_line = new LC\TableInfo( "内容", "content" );
        $content_line->setHandler( function ( $list, $obj )use( $app_info_all_keys ) {
            foreach ($list as $key => $value) {
                if( !\in_array( $key, $app_info_all_keys ) ) unset( $list[ $key ] );
            }

            return \json_encode( $list );
            return \var_export( $list, true );
        } );
        $ip_line = new LC\TableInfo( "IP", "ip" );
        $ip_line->setHandler( function ( $list, $obj ) {
            $value = "";
            isset( $list['ip'] ) && $value .= $list['ip'];
            isset( $list['ipv6'] ) && $value .= $list['ipv6'];

            return $value;
        } );
        $os_line = new LC\TableInfo( "机型", "os" );
        $os_line->setFilter( function( $value )use( $os_list ) {
            if( isset( $os_list[ $value ] ) ) {
                return $os_list[ $value ];
            }
            return "未知";
        } );
        $create_date_line = new LC\TableInfo( "日期", "create_date" );
        $create_time_line = new LC\TableInfo( "时间", "create_time" );
        //设置数据列
        $LCTable->setLines( [
            $id_line,
            $init_id_line,
            $ip_line,
            $os_line,
            $create_date_line,
            $create_time_line,
            $content_line,
        ] );

        return $LCTable->view( $view_data );
    }

    public function users( ) {
        $view_data = ['view_title'=>'应用激活'];
        $view_data['left_nav_name'] = "log_stream";
        $view_data['left_nav_li_name'] = "log_stream_users";

        $channel_list = array_flip( AppUsersFormatL::$channel_list );
        $os_list = array_flip( AppUsersFormatL::$os_list );

        $init_id = \request()->input( "init_id" );
        $unique_id = \request()->input( "unique_id" );
        $date = \request()->input( "date" );
        $channel = \request()->input( "channel" );
        $os = \request()->input( "os" );

        $app_id = GameAppController::getSessKey();

        $Logic = new AppUsersL( $app_id );
        $Model = $Logic->getTableModelObj();

        $where = [];
        !\is_null( $init_id ) && $where[] = [ "init_id", "=", $init_id ];
        !\is_null( $unique_id ) && $where[] = [ "unique_id", "=", $unique_id ];
        !\is_null( $date ) && $where[] = [ "create_date", "=", $date ];
        !\is_null( $channel ) && $where[] = [ "channel", "=", $channel ];
        !\is_null( $os ) && $where[] = [ "os", "=", $os ];

        $columns = ["id", "init_id", "unique_id", "reg_ip", "os", "channel", "create_date", "create_time"];
        $list = $Model->select( $columns )->where( $where )->orderBy( 'id', 'desc' )->paginate( 20 );
        $list->withPath( \url()->full() );

        $LCTable = new LC\Table( );
        //设置分页数据
        $LCTable->setPaginator( $list );

        $init_id_form = new LC\TableFormInput( "启动ID", "init_id", $init_id );
        $unique_id_form = new LC\TableFormInput( "点击ID", "unique_id", $unique_id );
        $date_form = new LC\TableFormInput( "日期", "date", $date );
        $date_form->inputType( "date" );
        $channel_form = new LC\TableFormSelect( "选择渠道", "channel", $channel );
        $channel_form->setOptions( $channel_list );
        $os_form = new LC\TableFormSelect( "选择机型", "os", $os );
        $os_form->setOptions( $os_list );

        $LCTable->setRows( [
            $init_id_form,
            $unique_id_form,
            $date_form,
            $channel_form,
            $os_form
        ] );

        $id_line = new LC\TableInfo( "#", "id" );
        $init_id_line = new LC\TableInfo( "启动ID", "init_id" );
        $unique_id_line = new LC\TableInfo( "点击ID", "unique_id" );
        $reg_ip_line = new LC\TableInfo( "IP", "reg_ip" );
        $channel_line = new LC\TableInfo( "渠道", "channel" );
        $channel_line->setFilter( function( $value )use( $channel_list ) {
            if( isset( $channel_list[ $value ] ) ) {
                return $channel_list[ $value ];
            }
            return "未知";
        } );
        $os_line = new LC\TableInfo( "机型", "os" );
        $os_line->setFilter( function( $value )use( $os_list ) {
            if( isset( $os_list[ $value ] ) ) {
                return $os_list[ $value ];
            }
            return "未知";
        } );
        $create_date_line = new LC\TableInfo( "日期", "create_date" );
        $create_time_line = new LC\TableInfo( "时间", "create_time" );
        //设置数据列
        $LCTable->setLines( [
            $id_line,
            $init_id_line,
            $unique_id_line,
            $reg_ip_line,
            $channel_line,
            $os_line,
            $create_date_line,
            $create_time_line,
        ] );

        return $LCTable->view( $view_data );
        
    }

    public function click( ) {
        $view_data = ['view_title'=>'广告点击'];
        $view_data['left_nav_name'] = "log_stream";
        $view_data['left_nav_li_name'] = "log_stream_click";

        $platform_id_list = array_flip( AppUsersFormatL::$channel_list );
        unset( $platform_id_list[0], $platform_id_list[100] );
        $os_list = array_flip( AppUsersFormatL::$os_list );
        //设备信息
        $app_info_list = [
            "imei" => "IMEI",
            "idfa" => "IDFA",
            "androidid" => "ANDROIDID",
            "oaid" => "OAID",
            "mac" => "MAC",
            "ip" => "IP",
        ];
        //设备附加信息
        $app_info_other_list = [
            "click_id" => "点击ID",
            "aid" => "广告计划ID",
            "cid" => "广告创意ID",
            "gid" => "广告组ID",
            "account_id" => "广告主ID",
            "ua" => "User-Agent",
            "callback_url" => "回调地址",
            "other" => "其他",
            "ts" => "毫秒时间搓",
        ];
        //设备信息键
        $app_info_all_keys = \array_keys( \array_merge( $app_info_other_list, $app_info_list ) );
        
        $unique_id = \request()->input( "unique_id" );
        $aid = \request()->input( "aid" );
        $date = \request()->input( "date" );
        $platform_id = \request()->input( "platform_id" );

        $app_info_key = \request()->input( "app_info_key" );
        $app_info_val = \request()->input( "app_info_val" );

        $app_id = GameAppController::getSessKey();

        $Logic = new AppClickDataL( $app_id );
        $Model = $Logic->getTableModelObj();

        $where = [];
        !\is_null( $unique_id ) && $where[] = [ "unique_id", "=", $unique_id ];
        !\is_null( $aid ) && $where[] = [ "aid", "=", $aid ];
        !\is_null( $date ) && $where[] = [ "create_date", "=", $date ];
        !\is_null( $platform_id ) && $where[] = [ "platform_id", "=", $platform_id ];
        if( 
            !\is_null( $app_info_key ) 
            && \in_array( $app_info_key, \array_keys( $app_info_list ) ) 
            && !\is_null( $app_info_val ) 
        ) {
            $where[] = [ $app_info_key, "=", $app_info_val ];
        }else{
            $app_info_key = $app_info_val = null;
        }

        $columns = ["id", "unique_id", "platform_id", "click_id", "aid", "cid", "gid", "account_id", "imei", "idfa", "androidid", "oaid", "mac", "ip", "ua", "os", "ts", "callback_url", "other", "create_date", "create_time"];
        $list = $Model->select( $columns )->where( $where )->orderBy( 'id', 'desc' )->paginate( 20 );
        $list->withPath( \url()->full() );

        $LCTable = new LC\Table( );
        $LCTable->pushSource( "js", asset('/'). "js/log_stream/byteclick.js" ); //额外js资源

        //设置分页数据
        $LCTable->setPaginator( $list );
        
        $unique_id_form = new LC\TableFormInput( "点击ID", "unique_id", $unique_id );
        $aid_form = new LC\TableFormInput( "广告计划ID", "aid", $aid );
        $date_form = new LC\TableFormInput( "日期", "date", $date );
        $date_form->inputType( "date" );
        $platform_id_form = new LC\TableFormSelect( "平台", "platform_id", $platform_id );
        $platform_id_form->setOptions( $platform_id_list );
        $app_info_key_form = new LC\TableFormSelect( "选择设备信息", "app_info_key", $app_info_key );
        $app_info_key_form->setOptions( $app_info_list );
        $app_info_val_form = new LC\TableFormInput( "输入设备信息值", "app_info_val", $app_info_val );

        $LCTable->setRows( [
            $unique_id_form,
            $aid_form,
            $date_form,
            $platform_id_form,
            $app_info_key_form,
            $app_info_val_form
        ] );

        $id_line = new LC\TableInfo( "#", "id" );
        $unique_id_line = new LC\TableInfo( "点击ID", "unique_id" );
        $aid_line = new LC\TableInfo( "广告计划ID", "aid" );
        $content_line = new LC\TableInfo( "内容", "content" );
        $content_line->setHandler( function ( $list, $obj )use( $app_info_all_keys ) {
            foreach ($list as $key => $value) {
                if( !\in_array( $key, $app_info_all_keys ) ) unset( $list[ $key ] );
            }

            return \json_encode( $list );
            return \var_export( $list, true );
        } );
        $ip_line = new LC\TableInfo( "IP", "ip" );
        $os_line = new LC\TableInfo( "机型", "os" );
        $os_line->setFilter( function( $value )use( $os_list ) {
            if( isset( $os_list[ $value ] ) ) {
                return $os_list[ $value ];
            }
            return "未知";
        } );
        $platform_id_line = new LC\TableInfo( "平台", "platform_id" );
        $platform_id_line->setFilter( function( $value )use( $platform_id_list ) {
            if( isset( $platform_id_list[ $value ] ) ) {
                return $platform_id_list[ $value ];
            }
            return "未知";
        } );
        $create_date_line = new LC\TableInfo( "日期", "create_date" );
        $create_time_line = new LC\TableInfo( "时间", "create_time" );
        $btns_line = new LC\TableBtns( "操作", "update" );
        $btns_line->pushBtn( "生成回调地址", "create_callback", "info" );
        //设置数据列
        $LCTable->setLines( [
            $id_line,
            $unique_id_line,
            $platform_id_line,
            $aid_line,
            $ip_line,
            $os_line,
            $create_date_line,
            $create_time_line,
            $btns_line,
            $content_line,
        ] );

        return $LCTable->view( $view_data );
    }

}
