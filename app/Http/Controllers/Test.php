<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Logic;
use App\BaseModel;

use App\Logic\LeadContent as LC;

class Test extends Controller
{
    public function index() {
    
        dump( \request()->all() );

        $LCForm = new LC\Form( "菜单申请", "get", url("/test") );
        $LCForm->setSubmitBtnName( "保存修改" );

        $name_row = new LC\FormInput( "姓名", "username", "lls" );
        // $name_row->disabled();
        $name_row->setPrompt( "username" );

        $age_row = new LC\FormInput( "年龄", "userage", "20" );
        $age_row->inputType( "number" );
        $age_row->setPrompt( "userage" );

        $like_row = new LC\FormCheckBox( "爱好", "like", "1,6,9" );
        $like_row->setOptions([1,2,3,4,5,6,7,8,9,10]);
        $like_row->setPrompt( "like" );

        $sex_row = new LC\FormRadio( "性别", "sex", "1" );
        $sex_row->setOptions(["女", "男"]);
        $sex_row->setPrompt( "sex" );

        $menu_row = new LC\FormSelect( "菜单", "menu", "1,2,4" );
        $menu_row->multiple();
        $menu_row->setOptions([
            1 => "红烧肉",
            "清蒸鸡",
            "清蒸鱼",
            "烤鸭",
            "烤鹅"
        ]);
        $menu_row->setintro( "这是多选框" );

        $menu2_row = new LC\FormSelect( "配菜", "menu2", "1" );
        $menu2_row->setOptions([
            1 => "酸豆角",
            "萝卜干",
            "榨菜",
            "辣椒",
            "香菜"
        ]);
        $menu2_row->setintro( "这是单选框" );

        $info_row = new LC\FormTextarea( "个人介绍", "info", "..." );
        $info_row->disabled();

        $LCForm->pushRow( $name_row );
        $LCForm->pushRow( $age_row );
        $LCForm->pushRow( $like_row );
        $LCForm->pushRow( $sex_row );
        $LCForm->pushRow( $menu_row );
        $LCForm->pushRow( $menu2_row );
        $LCForm->pushRow( $info_row );

        $view_data = ['view_title'=>'测试页面'];
        
        return $LCForm->view( $view_data );

        return \view("leadcontent.form");

        $data = [
            'byte_click' => Logic\AppByteClickData::getUrlQuery(),
            'byte_show' => Logic\AppByteShowData::getUrlQuery(),
        ];
        return \response()->json( static::jsonRes(404, null, $data) );
    }
}
