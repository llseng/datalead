<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-19 17:51:38 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-11-19 17:57:47
 */
namespace App\Logic\AppData\Click\Callback;

/**
 * undocumented class
 */
class ByteStrategy implements Strategy
{
    //激活
    public function init( array $data ) {
        return ['event_type' => 0];
    }

    //注册
    public function register( array $data ) {
        return ['event_type' => 1];
    }

    //次留
    public function keep2( array $data ) {
        return ['event_type' => 6];
    }
}
