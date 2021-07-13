<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-19 17:51:38 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-11-19 18:29:10
 */
namespace App\Logic\AppData\Click\Callback;

/**
 * undocumented class
 */
class KuaiShouStrategy implements Strategy
{
    //激活
    public function init( array $data ) {
        return [
            'event_type' => 1,
            'event_time' => \round( \microtime(true) * 1000 )
        ];
    }

    //注册
    public function register( array $data ) {
        return [
            'event_type' => 2,
            'event_time' => \round( \microtime(true) * 1000 )
        ];
    }

    //次留
    public function keep2( array $data ) {
        return [
            'event_type' => 7,
            'event_time' => \round( \microtime(true) * 1000 )
        ];
    }

    //关键行为
    public function cruxAction( array $data ) {
        return [
            'event_type' => 143,
            'event_time' => \round( \microtime(true) * 1000 )
        ];
    }
}
