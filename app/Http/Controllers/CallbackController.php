<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;
use App\GameAppCallback;
use App\Logic\LeadContent as LC;
use App\Logic\AppCallback as AppCallbackL;

class CallbackController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $view_data = ['view_title'=>'回调管理'];
        $view_data['left_nav_name'] = "callback";

        $appid = \request()->input("appid");
        $state = \request()->input("state");
        
        $Model = new GameAppCallback();
        //搜索条件
        $where = [];
        !\is_null( $appid ) && $where[] = [ "appid", "=", $appid ];
        !\is_null( $state ) && $where[] = [ "status", "=", $state ];
        
        $list = $Model->select("id", "appid", "query", "status", "created_at", "updated_at")->where( $where )->orderBy("id", "desc")->paginate( 20 );
        $list->withPath( \url()->full() );

        $app_list = GameAppController::getCacheList();

        $LCTable = new LC\Table( "回调列表" );
        $LCTable->pushDefAttr( "data-info-url", \route('callback_info') );
        $LCTable->pushDefAttr( "data-handle-url", \route('callback_handle') );
        $LCTable->pushDefAttr( "data-delete-url", \route('callback_delete') );
        $LCTable->pushSource( "js", asset('/'). "js/callback/index.js" ); //额外js资源

        $appid_form = new LC\TableFormSelect( "选择应用", "appid", $appid );
        $appid_form->setOptions( $app_list );
        $state_form = new LC\TableFormSelect( "选择状态", "state", $state );
        $state_form->setOptions( [ "未处理", "已处理" ] );
        //设置搜索行
        $LCTable->setRows( [$appid_form, $state_form] );

        $id_line = new LC\TableInfo( "#", "id" );
        $appid_line = new LC\TableInfo( "应用", "appid" );
        $url_line = new LC\TableInfo( "地址", "url" );
        // $url_line->setFilter( function ( $value ) {
        //     return strlen( $value ) > 20? substr($value, 0, 17). "...": $value;
        // } );
        $query_line = new LC\TableInfo( "回调", "query" );
        $res_line = new LC\TableInfo( "响应", "res" );
        // $res_line->setFilter( function ( $value ) {
        //     return strlen( $value ) > 20? substr($value, 0, 17). "...": $value;
        // } );
        $status_line = new LC\TableInfo( "状态", "status" );
        $status_line->setFilter( function ( $value ) {
            $val;
            switch ( (int)$value ) {
                case 0:
                    $val = "未处理";
                    break;
                case 1:
                    $val = "已处理";
                    break;
                default:
                    $val = "未知";
                    break;
            }
            return $val;
        } );
        $created_at_line = new LC\TableInfo( "创建时间", "created_at" );
        $updated_at_line = new LC\TableInfo( "变更时间", "updated_at" );
        $btns_line = new LC\TableBtns( "操作", "update" );
        $btns_line->pushBtn( "详情", "info", "info" );
        $btns_line->pushBtn( "处理", "handle", "warn" );
        $btns_line->pushBtn( "删除", "delete", "error" );
        //设置数据列
        $LCTable->setLines( [
            $id_line,
            $appid_line,
            $url_line,
            $query_line,
            $res_line,
            $status_line,
            $created_at_line,
            $updated_at_line,
            $btns_line
        ] );
        //设置分页数据
        $LCTable->setPaginator( $list );

        return $LCTable->view( $view_data );

    }

    public function info( ) {
        $id = (int)\request()->input( "id" );
        if( empty( $id ) ) {
            return \response()->json( static::jsonRes( 400, "参数异常" ) );
        }
        
        $GameAppCallback = GameAppCallback::find( $id );
        if( empty( $GameAppCallback ) ) {
            return \response()->json( static::jsonRes( 404, "记录不存在" ) );
        }

        return \response()->json( static::jsonRes( 0, null, $GameAppCallback->toArray(), false ) );

    }

    public function handle( ) {
        $id = (int)\request()->input( "id" );
        if( empty( $id ) ) {
            return \response()->json( static::jsonRes( 400, "参数异常" ) );
        }
        
        $GameAppCallback = GameAppCallback::find( $id );
        if( empty( $GameAppCallback ) ) {
            return \response()->json( static::jsonRes( 404, "记录不存在" ) );
        }

        if( $GameAppCallback->status ) {
            return \response()->json( static::jsonRes( 400, "记录已处理" ) );
        }

        $url = $GameAppCallback->url;
        
        if( $GameAppCallback->query ) {
            $url .= \strpos( $url, '?' )? '&': '?';
            $url .= $GameAppCallback->query;
        }

        $result = AppCallbackL::handle( $GameAppCallback->toArray() );
        if( $result === false ) {
            $result = 'request_fail';
            static::$Logger->error( $GameAppCallback->id . " req fail" );
        }
        
        $update_status = AppCallbackL::update( $GameAppCallback->id , $result );
        if( !$update_status ) {
            Log::error( __method__ . ": $id update fail"  );
            return \response()->json( static::jsonRes( 500, "处理失败,请稍后再试." ) );
        }

        $data = [ "id" => $id , "url" => $GameAppCallback->url, "res" =>  $result, "datetime" => date("Y-m-d H:i:s")];
        return \response()->json( static::jsonRes( 0, null, $data, false ) );
    }

    public function delete( ) {
        $id = (int)\request()->input( "id" );
        if( empty( $id ) ) {
            return \response()->json( static::jsonRes( 400, "参数异常" ) );
        }
        
        $GameAppCallback = GameAppCallback::find( $id );
        if( empty( $GameAppCallback ) ) {
            return \response()->json( static::jsonRes( 404, "记录不存在" ) );
        }

        $delete_status = $GameAppCallback->delete();
        if( !$delete_status ) {
            Log::error( __method__ . ": $id delete fail"  );
            return \response()->json( static::jsonRes( 500, "删除失败,请稍后再试." ) );
        }

        $data = [ "id" => $id ];
        return \response()->json( static::jsonRes( 0, null, $data, false ) );
    }

}
