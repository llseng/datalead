<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Http\FormRequest;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 返回操作错误
     *
     * @param string $error
     * @return void
     */
    static public function backError( $error ) {
        return back()->withErrors( static::dealError($error) );
    }

    static public function dealError( $error ) {
        return [ 'deal_error' => $error ];
    }
    
    static public function jsonRes( $code = 0, $message = null, $data = [], $merge = true ) {
        if( \is_null( $message ) ) $message = $code == 0? "SUCCESS": "FAIL";
        $res = [ 'code' => $code, 'message' => $message ];
        
        if( $data ) {
            $merge? $res = \array_merge( $res, $data ): $res['data'] = $data;
        }

        return $res;
    }

    static public function jsonValidate( FormRequest $classObj, array $data, &$fails ) {
        if( 
            \method_exists( $classObj, 'authorize' ) 
            && \call_user_func( [$classObj, 'authorize'] ) == false 
            ) {
            $fails = false;
            return static::jsonRes( 401, 'Permissions' );
        }

        $validator = Validator::make( $data, $classObj->rules(), $classObj->messages(), $classObj->attributes() );
        
        if( \method_exists( $classObj, 'withValidator' ) ) {
            \call_user_func( [$classObj, 'withValidator'], $validator );
        }

        if( $validator->fails() ) {
            $fails = false;
            return static::jsonRes( 400, 'Validation Fails', $validator->errors()->messages(), false );
        }

        $fails = true;
        return static::jsonRes();
    }
}
