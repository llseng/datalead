<?php

namespace App\Http\Middleware\Api;

use Closure;

use App\Http\Controllers\GameAppController;

class GameAppIdCheck
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
        $app_id = $request->route( 'app_id' );
        if( $app_id ) {
            $app_list = GameAppController::getCacheList();
            if( !\in_array( $app_id, \array_keys( $app_list ) ) ) {
                return \response()->json( GameAppController::jsonRes( 404, "There Is No Application" ) );
            }
        }

        return $next($request);
    }
}
