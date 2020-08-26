<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Logic\LeadContent as LC;

use App\Http\Requests\UserPwdReset as UserPwdResetVali;
use App\Http\Requests\User as UserVali;

class UserController extends Controller
{
    public function __construct( ) {
        $this->middleware('auth');
    }

    public function index() {
        $view_data = ['view_title'=>'用户详情'];
        //当前登录用户数据
        $user = Auth::user();
        
        $LCForm = new LC\Form( "设置密码", "POST", route( "user_reset_pwd" ) );
        $LCForm->setSubmitBtnName( "保存修改" );

        $name_row = new LC\FormInput( "用户名", "name", $user->name );
        $name_row->disabled();

        $email_row = new LC\FormInput( "用户邮箱", "email", $user->email );
        $email_row->disabled();

        $created_row = new LC\FormInput( "创建时间", "", $user->created_at );
        $created_row->disabled();

        $curr_pwd_row = new LC\FormInput( "当前密码", "curr_pwd", "" );
        $password_row = new LC\FormInput( "新密码", "password", "" );
        $password_confirmation_row = new LC\FormInput( "确认新密码", "password_confirmation", "" );

        $LCForm->setRows( [
            $name_row,
            $email_row,
            $created_row,
            $curr_pwd_row,
            $password_row,
            $password_confirmation_row,
        ] );
        
        return $LCForm->view( $view_data );
    }

    public function reset_pwd( UserPwdResetVali $request ) {
        $curr_pwd = $request->get("curr_pwd");
        $password = $request->get("password");

        $user = Auth::user();

        if( !Hash::check( $curr_pwd, $user->password ) ) {
            return static::backError( "密码错误" );
        }

        if( $curr_pwd == $password ) {
            return static::backError( "新密码不可与当前密码一致" );
        }

        $user->password = \bcrypt( $password );

        if( !$user->save() ) {
            return static::backError( "修改失败" );
        }

        return static::backSuccess( "操作成功" );
    }

    public function dealwith( UserVali $request ) {
        

        return static::backSuccess( "操作成功" );
    }
}
