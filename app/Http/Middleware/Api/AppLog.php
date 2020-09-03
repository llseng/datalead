<?php

namespace App\Http\Middleware\Api;

use Log;
use Closure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AppLog as AppLogVali;

class AppLog
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
        $req_data = $request->all();
        $vali = new AppLogVali;
        $must_succ_keys = \array_keys( $vali->rules() );
        //验证统一请求验证
        $valiRes = Controller::jsonValidateFilter( new AppLogVali, $req_data, $valiStatus, $must_succ_keys );
        if( !$valiStatus ) {
            Log::debug( static::class .': valiFail', $valiRes );
            return \response()->json( $valiRes );
        }

        return $next($request);
    }
}
