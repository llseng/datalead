<?php

namespace App\Http\Middleware;

use Closure;
use App\GameApp;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GameAppController;

class GameAppCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( !$request->session()->exists( GameAppController::$sessKey ) ) {
            $request->session()->put(GameAppController::$sessKey, []);
        }
        $gameapp = GameAppController::getSess();

        if( !isset( $gameapp['list'] ) ) {
            GameAppController::setSessList( );
        }
        $list = GameAppController::getSessList();

        if( empty( $list ) ) {
            return redirect()->route('game')->withErrors( Controller::dealError( "无应用数据,请创建." ) );
        }
        
        if( 
            empty( $gameapp['key'] ) 
            || !\in_array( $gameapp['key'], \array_keys( $list ) ) 
        ) {
            GameAppController::setSessKey( \key( $list ) );
            GameAppController::setSessVal( \current( $list ) );
        }
        $key = GameAppController::getSessKey();
        $val = GameAppController::getSessVal();

        return $next($request);
    }
}
