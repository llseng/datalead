<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Logic;
use App\BaseModel;

use App\Logic\LeadContent as LC;
use App\Logic\AppByteClickData as AppByteClickDataL;
use App\Logic\AppInitData as AppInitDataL;
use App\Http\Requests\Test as TestVali;

class Test extends Controller
{
    public function index(TestVali $request) {
        $Table = new LC\Table();

        $pid_form = new LC\TableFormInput( '启动ID', 'init_id', \request()->get('init_id') );
        // $pid_form->inputType( "number" );
        $age_form = new LC\TableFormInput( '启动IP', 'ip', \request()->get('ip') );
        // $age_form->inputType( "number" );
        $date_form = new LC\TableFormInput( '日期', 'date', \request()->get('date') );
        $date_form->inputType( "date" );
        $level_form = new LC\TableFormSelect( '系统', 'os', \request()->get('os') );
        $level_form->setOptions( [
            1 => "Android",
            2 => "IOS"
        ] );

        $Table->setRows( [$pid_form, $age_form, $date_form, $level_form] );

        // $Table->noFormBlock();

        $id_line = new LC\TableInfo( "#", "id" );
        $initid_line = new LC\TableInfo( "INITID", "init_id" );
        $name_line = new LC\TableInfo( "IP", "ip" );
        $age_line = new LC\TableInfo( "日期", "create_date" );
        $level_line = new LC\TableInfo( "时间", "create_time" );
        $btns_line = new LC\TableBtns( "操作", "update" );
        $btns_line->pushBtn( "修改", "s", "success" );

        $Table->setLines( [$id_line, $initid_line, $name_line, $age_line, $level_line, $btns_line] );

        $AppInitDataL = new AppInitDataL( "tests" );
        $init_list = $AppInitDataL->getTableModelObj()->paginate( 100 );
        $init_list->withPath( \url()->full() ); //设置分页URL

        // $list_data = $init_list->toArray();
        // $Table->setData( $list_data['data'] );
        // $Table->setPages( $init_list->links() );
        $Table->setPaginator( $init_list );

        return $Table->view( );

        $data = [];
        return \response()->json( static::jsonRes(404, null, $data) );
    }
}
