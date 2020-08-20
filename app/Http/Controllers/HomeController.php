<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppInitData as AppInitDataL;
use App\Logic\AppByteShowData as AppByteShowDataL;
use App\Logic\AppByteClickData as AppByteClickDataL;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view_data = ['view_title'=>'总览'];
        $view_data['left_nav_name'] = "home";

        $app_id = GameAppController::getSessKey();
        $view_data['app_id'] = $app_id;

        $AppUsersL = new AppUsersL( $app_id );
        $AppInitDataL = new AppInitDataL( $app_id );
        $AppByteShowDataL = new AppByteShowDataL( $app_id );
        $AppByteClickDataL = new AppByteClickDataL( $app_id );

        $view_data['count'] = [
            'total_show' => $AppByteShowDataL->count(),
            'total_click' => $AppByteClickDataL->count(),
            'total_init' => $AppInitDataL->count(),
            'total_users' => $AppUsersL->count(),
        ];

        return view('home', $view_data);
    }
}
