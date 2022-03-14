<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Logic;
use App\GameApp;
use App\BaseModel;
use App\GameAppConfig;
use App\Http\Requests\GameApp as GameAppVali;

use App\Logic\LeadContent as LC;
use App\Logic\AppData\Click\UrlQuery as UQ;

class GameAppController extends Controller
{

    private $logicClass = [
        \App\Logic\AppUsers::class,
        \App\Logic\AppInitData::class,
        \App\Logic\AppClickData::class,
        \App\Logic\AppSortNames::class,
        \App\Logic\AppSortNames::class,
        \App\Logic\AppUserAction::class,
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    static public $fields = ['id as gid', 'name', 'desc', 'download_url', 'created_at'];

    static public $sessKey = "gameapp";

    static public function setSessList( ) {
        return session()->put( static::$sessKey.'.list', static::getCacheList() );
    }

    static public function setSessKey( $key ) {
        return session()->put( static::$sessKey.'.key', $key );
    }

    static public function setSessVal( $val ) {
        return session()->put( static::$sessKey.'.val', $val );
    }

    static public function getSessList( ) {
        return session()->get( static::$sessKey.'.list' );
    }

    static public function getSessKey( ) {
        return session()->get( static::$sessKey.'.key' );
    }

    static public function getSessVal( ) {
        return session()->get( static::$sessKey.'.val' );
    }

    static public function flushSess( $key ) {
        static::setCacheList( );
        static::setSessList( );
        if( static::getSessKey() == $key ) {
            static::setSessKey( \key( static::getSessList( ) ) );
            static::setSessVal( \current( static::getSessList( ) ) );
        }
    }

    static public function getSess( ) {
        return session()->get( static::$sessKey );
    }

    static public function cleanSess( ) {
        return session()->put( static::$sessKey, [] );
    }

    static public function setCacheList( ) {
        $list = GameApp::pluck('name', 'id')->toArray();
        return cache()->put( static::$sessKey.'_list', $list, 10080 );
    }

    static public function getCacheList( ) {
        return cache()->remember( static::$sessKey.'_list', 10080, function () {
            return GameApp::pluck('name', 'id')->toArray();
        } );
    }

    public function index() {
        $view_data = ['view_title'=>'应用'];
        $view_data['left_nav_name'] = "game";
        
        $app_list = GameApp::select( static::$fields )->orderBy("created_at")->get();
        $view_data['app_list'] = $app_list;
        
        return view('m_game.list', $view_data);
    }

    public function select(Request $request, $id ) {
        $GameApp = GameApp::select( static::$fields )->find( $id );
        if( empty( $GameApp ) ) {
            return static::backError( "错误,请刷新后再试." );
        }

        static::setSessKey( $GameApp->gid );
        static::setSessVal( $GameApp->name );

        // return redirect()->route('home');
        return back();
    }

    public function create() {

        $LCForm = new LC\Form( "创建应用", "POST", route('game_dealwith') );
        $LCForm->pushHideData( "old_id", '' );

        $id_form = new LC\FormInput( "ID", "id" );
        $name_form = new LC\FormInput( "名称", "name");
        $desc_form = new LC\FormInput( "简介", "desc" );
        $download_url_form = new LC\FormInput( "下载地址", "download_url");

        $LCForm->setRows( [
            $id_form,
            $name_form,
            $desc_form,
            $download_url_form,
        ] );
        
        return $LCForm->view( );
    }

    public function update( $id ) {
        $view_data = ['view_title'=>'修改应用'];
        $GameApp = GameApp::select( static::$fields )->find( $id );
        if( empty( $GameApp ) ) {
            return static::backError( "错误,请刷新后再试." );
        }
        
        $LCForm = new LC\Form( "创建应用", "POST", route('game_dealwith') );
        $LCForm->pushHideData( "old_id", $GameApp->gid );

        $id_form = new LC\FormInput( "ID", "id", $GameApp->gid );
        $id_form->setPrompt( "不可修改" );
        $name_form = new LC\FormInput( "名称", "name", $GameApp->name );
        $desc_form = new LC\FormInput( "简介", "desc", $GameApp->desc  );
        $download_url_form = new LC\FormInput( "下载地址", "download_url", $GameApp->download_url );

        $LCForm->setRows( [
            $id_form,
            $name_form,
            $desc_form,
            $download_url_form,
        ] );
        
        return $LCForm->view( );
    }

    public function delete(Request $request, $id ) {
        if( !$request->delete ) return static::backError( "删除应用请联系维护人员." );
        $GameApp = GameApp::find( $id );
        if( empty( $GameApp ) ) {
            return static::backError( "错误,请刷新后再试." );
        }

        $status = $GameApp->delete();

        if( !$status ) {
            return static::backError( "操作失败,请稍后再试." );
        }

        $this->deleteTables( $id );

        static::flushSess( $id );

        return redirect()->route('game');
    }

    public function dealwith(GameAppVali $request) {
        $data = $request->all();
        $status = false;
        if( $data['old_id'] ) {
            $GameApp = GameApp::find( $data['old_id'] );
            if( empty( $GameApp ) ) {
                return static::backError( "错误,请刷新后再试." );
            }
            $status = GameApp::where( 'id', $data['old_id'] )->update([
                // 'id' => $data['id'],
                'name' => $data['name'],
                'desc' => $data['desc'],
                'download_url' => $data['download_url']
            ]);
        }else{
            $GameApp = new GameApp;
            $GameApp->id = $data['id'];
            $GameApp->name = $data['name'];
            $GameApp->desc = $data['desc'];
            $GameApp->download_url = $data['download_url'];
            
            $status = $GameApp->save();

            $status && $this->copyTablesStruct( $data['id'] );
            
        }

        if( !$status ) {
            return static::backError( "操作失败,请稍后再试." );
        }

        static::flushSess( $data['old_id'] );

        return redirect()->route('game');
    }

    public function info( $id ) {
        return redirect()->route('game_info_v2');
    }

    public function info_v2( $id ) {
        $GameApp = GameApp::find( $id );
        if( empty( $GameApp ) ) {
            return static::backError( "错误,请刷新后再试." );
        }

        $view_data['left_nav_name'] = "game";

        $LCForm = new LC\Form( "应用详情" );
        $LCForm->noSubmitBtn();

        $id_form = new LC\FormInput( "ID", "id", $GameApp->id );
        $id_form->disabled();
        $name_form = new LC\FormInput( "名称", "name", $GameApp->name );
        $name_form->disabled();
        $desc_form = new LC\FormInput( "简介", "desc", $GameApp->desc );
        $desc_form->disabled();
        $download_url_form = new LC\FormInput( "下载地址", "download_url", $GameApp->download_url );
        $download_url_form->disabled();

        $init_link_form = new LC\FormTextarea( "启动监听连接", "", \route( 'app_init_v2', ['id' => $id] ) );
        $byte_click_link_form = new LC\FormTextarea( "字节广告点击监听连接", "", \route( 'app_click_byte', ['id' => $id] ). "?". UQ\ByteUrlQuery::toString() );
        $kuaishou_click_link_form = new LC\FormTextarea( "快手广告点击监听连接", "", \route( 'app_click_kuaishou', ['id' => $id] ). "?". UQ\KuaiShouUrlQuery::toString() );
        $txad_click_link_form = new LC\FormTextarea( "腾讯广告点击监听连接", "", \route( 'app_click_txad', ['id' => $id] ) );
        $huawei_click_link_form = new LC\FormTextarea( "华为广告点击监听连接", "", \route( 'app_click_huawei', ['id' => $id] ). "?". UQ\HuaweiUrlQuery::toString() );

        $LCForm->setRows( [
            $id_form,
            $name_form,
            $desc_form,
            $download_url_form,

            $init_link_form,
            $byte_click_link_form,
            $kuaishou_click_link_form,
            $txad_click_link_form,
            $huawei_click_link_form,
        ] );
        
        return $LCForm->view( $view_data );
    }

    private function copyTablesStruct( $app_id ) {
        $result = [
            "succ" => 0,
            "fail" => 0,
        ];
        foreach ($this->logicClass as $class) {
            $logic = new $class( $app_id );
            $status = $logic->create_table();
            if( $status ) $result['succ']++;
            else $result['fail']++;
        }
        unset( $logic );

        return $result;
    }

    private function deleteTables( $app_id ) {
        $result = [
            "succ" => 0,
            "fail" => 0,
        ];
        foreach ($this->logicClass as $class) {
            $logic = new $class( $app_id );
            $status = $logic->delete_table();
            if( $status ) $result['succ']++;
            else $result['fail']++;
        }
        unset( $logic );

        return $result;
    }

    public function setConfigs( $id ) {
        $view_data = ['view_title'=>'设置配置'];
        $GameApp = GameApp::select( static::$fields )->find( $id );
        if( empty( $GameApp ) ) {
            return static::backError( "错误,请刷新后再试." );
        }

        $config_list = GameAppConfig::configsByAppId( $id )->toArray();
        $configs = \array_column( $config_list, 'data', 'name' );
        
        $LCForm = new LC\Form( "配置", "POST", route('game_config_dealwith') );
        $LCForm->pushHideData( 'app_id', $id );

        $huawei_secret_row = new LC\FormInput( "华为秘钥", "huawei_secret", $configs['huawei_secret'] ?? null );
        $huawei_secret_row->setintro( "base64编码的加密密钥,由Huawei Ads平台生成" );

        $LCForm->setRows( [
            $huawei_secret_row,
        ] );
        
        return $LCForm->view( );
    }

    public function configsDealwith( Request $request ) {
        $data = $request->all();
        $status = true;

        $GameApp = GameApp::find( $data['app_id'] );
        if( ! $GameApp ) {
            return static::backError( "错误,请刷新后再试." );
        }

        $config_keys = [
            'huawei_secret'
        ];

        foreach ($data as $key => $value) {
            if( ! \in_array( $key, $config_keys ) ) continue;

            $row = GameAppConfig::where( 'app_id', $data['app_id'] )->where( 'name', $key )->first();
            if( $row ) {
                $row->data = $value;
                $status &= \boolval( $row->save() );
            }else{
                $status &= \boolval( GameAppConfig::create( [
                    'app_id' => $data['app_id'],
                    'name' => $key,
                    'data' => $value
                ] ) );
            }
        }

        if( !$status ) {
            return static::backError( "操作失败,请稍后再试." );
        }

        return redirect()->route('game');
    }
}
