<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-19 17:51:38 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-11-19 17:57:47
 */
namespace App\Logic\AppData\Click\Callback;
use App\Logic\AppCallback as AppCallbackL;

/**
 * undocumented class
 */
class ByteStrategy implements Strategy
{
    //激活
    public function init( array $data ) {
        $res = ['event_type' => 0];

        return AppCallbackL::create( $data['app_id'], $data['callback_url'], \http_build_query( $res ) );
    }

    //注册
    public function register( array $data ) {
        $res = ['event_type' => 1];

        return AppCallbackL::create( $data['app_id'], $data['callback_url'], \http_build_query( $res ) );
    }

    //次留
    public function keep2( array $data ) {
        $res = ['event_type' => 6];

        return AppCallbackL::create( $data['app_id'], $data['callback_url'], \http_build_query( $res ) );
    }

    //关键行为
    public function cruxAction( array $data ) {
        $res = ['event_type' => 25];

        return AppCallbackL::create( $data['app_id'], $data['callback_url'], \http_build_query( $res ) );
    }
}
