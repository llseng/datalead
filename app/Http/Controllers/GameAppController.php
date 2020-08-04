<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Logic;
use App\GameApp;
use App\Http\Requests\GameApp as GameAppVali;

class GameAppController extends Controller
{
    
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
        
        $app_list = GameApp::select( static::$fields )->get();
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
        $view_data = ['view_title'=>'创建应用'];
        $view_data['app_data'] = \array_fill_keys( \array_merge( static::$fields, ['gid']), '' );
        
        return view('m_game.form', $view_data);
    }

    public function update( $id ) {
        $view_data = ['view_title'=>'修改应用'];
        $GameApp = GameApp::select( static::$fields )->find( $id );
        if( empty( $GameApp ) ) {
            return static::backError( "错误,请刷新后再试." );
        }
        
        $view_data[ 'app_data' ] = $GameApp;

        return view('m_game.form', $view_data);
    }

    public function delete(Request $request, $id ) {
        $GameApp = GameApp::find( $id );
        if( empty( $GameApp ) ) {
            return static::backError( "错误,请刷新后再试." );
        }

        $status = $GameApp->delete();

        if( !$status ) {
            return static::backError( "操作失败,请稍后再试." );
        }

        static::flushSess( $id );

        return redirect()->route('game');;
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
                'id' => $data['id'],
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
        }

        if( !$status ) {
            return static::backError( "操作失败,请稍后再试." );
        }

        static::flushSess( $data['old_id'] );

        return redirect()->route('game');
    }

    public function info( $id ) {
        $GameApp = GameApp::find( $id );
        if( empty( $GameApp ) ) {
            return static::backError( "错误,请刷新后再试." );
        }

        $view_data = ['view_title'=>'应用详情'];
        $view_data['left_nav_name'] = "game";

        $view_data['app_data'] = $GameApp;
        //字节点击监测连接
        $view_data['app_click_link'] = \route( 'byte_click', ['id' => $id] ). '?'. Logic\AppByteClickData::getUrlQuery();
        //字节展示监测连接
        $view_data['app_show_link'] = \route( 'byte_show', ['id' => $id] ). '?'. Logic\AppByteShowkData::getUrlQuery();
        
        return view('m_game.info', $view_data);
    }
}
