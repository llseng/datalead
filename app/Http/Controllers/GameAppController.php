<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
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

    public function index() {
        $view_data = ['view_title'=>'应用'];
        
        $app_list = GameApp::select('id', 'name', 'desc', 'created_at')->get();
        $view_data['app_list'] = $app_list;

        dump( $app_list );
        return view('m_game.list', $view_data);
    }

    public function create() {
        $view_data = ['view_title'=>'创建应用'];
        return view('m_game.form', $view_data);
    }

    public function update() {
        return back();
        $view_data = ['view_title'=>'修改应用'];
        return view('m_game.form', $view_data);
    }

    public function dealwith(GameAppVali $request) {
        $MessageBag = new MessageBag;
        $MessageBag->add('base_deal', "操作失败,稍后再试");
        return back()->withErrors( $MessageBag );
        
        $data = $request->all();
        $status = false;
        if( $data['old_id'] ) {
            $GameApp = GameApp::find( $data['old_id'] );
            $GameApp->id = $data['id'];
            $GameApp->name = $data['name'];
            $GameApp->desc = $data['desc'];
            $GameApp->download_url = $data['download_url'];
            
            $status = $GameApp->save();
        }else{
            $GameApp = new GameApp;
            $GameApp->id = $data['id'];
            $GameApp->name = $data['name'];
            $GameApp->desc = $data['desc'];
            $GameApp->download_url = $data['download_url'];
            
            $status = $GameApp->save();
        }

        if( !$status ) {
            $MessageBag = new MessageBag;
            $MessageBag->add('base_deal', "操作失败,稍后再试");
            return back()->withErrors( $MessageBag );
        }
        return redirect()->route('game');
    }
}
