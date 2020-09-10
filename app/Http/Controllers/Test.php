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

        $pid_form = new LC\TableFormInput( '玩家ID', 'pid', \request()->get('pid') );
        // $pid_form->inputType( "number" );
        $age_form = new LC\TableFormInput( '玩家年龄', 'age', \request()->get('age') );
        // $age_form->inputType( "number" );
        $date_form = new LC\TableFormInput( '注册时间', 'date', \request()->get('date') );
        $date_form->inputType( "date" );
        $level_form = new LC\TableFormSelect( '玩家等级', 'level', \request()->get('level') );
        $level_form->setOptions( [1,2,3,4,5,6,7,8,9] );

        $Table->setRows( [$pid_form, $age_form, $date_form, $level_form] );

        // $Table->noFormBlock();

        $id_line = new LC\TableInfo( "#", "idd" );
        $name_line = new LC\TableInfo( "名称", "name" );
        $age_line = new LC\TableInfo( "年龄", "age" );
        $age_line->setHandler( function( $list, $obj ) {
            $str = "";
            $str .= ( isset( $list[ $obj->getName() ] )? $list[ $obj->getName() ]: '未知' );
            $str .= "岁";
            return $str;
        } );
        $level_line = new LC\TableInfo( "等级", "level" );
        $btns_line = new LC\TableBtns( "操作", "" );
        $btns_line->pushBtn( "修改", "s", "success" );

        $Table->setLines( [$id_line, $name_line, $age_line, $level_line, $btns_line] );

        $id = 0;
        $data = [
            ['idd' => $id++, "name" => "name_". rand( 1000, 9999 ), "age" => rand( 10, 99 ), "level" => rand( 1, 10 ) ],
            ['idd' => $id++, "name" => "name_". rand( 1000, 9999 ), "age" => rand( 10, 99 ), "level" => rand( 1, 10 ) ],
            ['idd' => $id++, "name" => "name_". rand( 1000, 9999 ), "age" => rand( 10, 99 ), "level" => rand( 1, 10 ) ],
            ['idd' => $id++, "name" => "name_". rand( 1000, 9999 ), "age" => rand( 10, 99 ), "level" => rand( 1, 10 ) ],
            ['idd' => $id++, "name" => "name_". rand( 1000, 9999 ), "age" => rand( 10, 99 ), "level" => rand( 1, 10 ) ],
            ['idd' => $id++, "name" => "name_". rand( 1000, 9999 ), "age" => rand( 10, 99 ), "level" => rand( 1, 10 ) ],
            ['idd' => $id++, "name" => "name_". rand( 1000, 9999 ), "age" => rand( 10, 99 ), "level" => rand( 1, 10 ) ]
        ];

        $Table->setData( $data );

        $AppInitDataL = new AppInitDataL( "tests" );
        $init_list = $AppInitDataL->getTableModelObj()->paginate( 15 );
        $init_list->withPath( \url()->full() );
        return $Table->view( ["pages" => $init_list->links()] );

        $data = [];
        return \response()->json( static::jsonRes(404, null, $data) );
    }
}
