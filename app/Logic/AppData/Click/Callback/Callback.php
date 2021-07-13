<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-19 16:26:28 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-11-19 17:46:47
 */
namespace App\Logic\AppData\Click\Callback;

/**
 * 回调
 */
class Callback
{
    private $app_id;

    private $strategy;
    
    private $data = [];

    public function __construct( $app_id ) {
        $this->app_id = $app_id;
    }

    public function setStrategy( Strategy $strategy ) {
        $this->strategy = $strategy;
    }

    public function getStrategy( ) {
        if( !isset( $this->strategy ) ) {
            $this->setStrategy( new ByteStrategy() );
        }

        return $this->strategy;
    }

    public function setData( array $data ) {
        $this->data = $data;
    }

    public function getData( ) {
        return \array_merge( $this->data, ['app_id' => $this->app_id] );
    }

    //激活
    public function init( ) {
        return $this->getStrategy()->init( $this->getData() );
    }
    //注册
    public function register( ) {
        return $this->getStrategy()->register( $this->getData() );
    }
    //次留
    public function keep2( ) {
        return $this->getStrategy()->Keep2( $this->getData() );
    }
    //关键行为
    public function cruxAction( ) {
        return $this->getStrategy()->cruxAction( $this->getData() );
    }
}
