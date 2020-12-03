<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-19 15:41:40 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-11-19 17:48:11
 */
namespace App\Logic\AppData\Click\Callback;

/**
 * 事件回调
 */
interface Strategy
{
    //激活
    public function init( array $data );
    //注册
    public function register( array $data );
    //次留
    public function keep2( array $data );
}
