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

    /**
     * 返回操作成功
     *
     * @param string $error
     * @return void
     */
    static public function backSuccess( $success ) {
        return back()->withErrors( static::dealSuccess($success) );
    }

    static public function dealError( $error ) {
        return [ 'deal_error' => $error ];
    }

    static public function dealSuccess( $success ) {
        return [ 'deal_success' => $success ];
    }
    
    /**
     * 统一json返回
     *
     * @param integer $code
     * @param string $message
     * @param array $data
     * @param boolean $merge
     * @return array
     */
    static public function jsonRes( $code = 0, $message = null, array $data = null, $merge = true ) {
        if( \is_null( $message ) ) $message = $code == 0? "SUCCESS": "FAIL";
        $res = [ 'code' => $code, 'message' => $message ];
        
        if( !is_null( $data ) ) {
            $merge? $res = \array_merge( $res, $data ): $res['data'] = $data;
        }

        return $res;
    }

    /**
     * 执行表单验证
     *
     * @param FormRequest $classObj
     * @param array $data
     * @return Illuminate\Validation\Validator
     */
    static public function runValidate( FormRequest $classObj, array $data ) {
        if( 
            \method_exists( $classObj, 'authorize' ) 
            && \call_user_func( [$classObj, 'authorize'] ) == false 
            ) {
            throw new \Exception( get_class( $classObj ). ": Not authorized the request", 1);
        }

        $validator = Validator::make( $data, $classObj->rules(), $classObj->messages(), $classObj->attributes() );
        
        if( \method_exists( $classObj, 'withValidator' ) ) {
            \call_user_func( [$classObj, 'withValidator'], $validator );
        }

        return $validator;
    }

    /**
     * 执行表单验证,返回 jsonRes
     *
     * @param FormRequest $classObj
     * @param array $data
     * @param $fails
     * @return jsonRes
     */
    static public function jsonValidate( FormRequest $classObj, array $data, &$fails ) {
        try {
            $validator = static::runValidate( $classObj, $data );
        } catch (\Throwable $th) {
            $fails = false;
            return static::jsonRes( 401, 'Permissions' );
        }

        if( $validator->fails() ) {
            $fails = false;
            return static::jsonRes( 400, 'Validation Fails', $validator->errors()->messages(), false );
        }

        $fails = true;
        return static::jsonRes();
    }

    /**
     * 执行表单验证并过滤,返回 jsonRes
     *
     * @param FormRequest $classObj
     * @param array &$data
     * @param $fails
     * @param array $must_succ_keys 必须正确的键
     * @return jsonRes
     */
    static public function jsonValidateFilter( FormRequest $classObj, array &$data, &$fails, array $must_succ_keys = null ) {
        try {
            $validator = static::runValidate( $classObj, $data );
        } catch (\Throwable $th) {
            $fails = false;
            return static::jsonRes( 401, 'Permissions' );
        }

        if( $validator->fails() ) {
            $valiErrors = $validator->errors();
            if( !empty( $must_succ_keys ) && $valiErrors->hasAny( $must_succ_keys ) ) {
                $fails = false;
                return static::jsonRes( 400, 'Validation Fails', $valiErrors->messages(), false );
            }
            
            $fail_keys = $valiErrors->keys();
            $data = \array_except( $data, $fail_keys );
        }

        $fails = true;
        return static::jsonRes();
    }

}
