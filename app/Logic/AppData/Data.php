<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-13 15:16:45 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-11-13 17:14:19
 */
namespace App\Logic\AppData;

/**
 * 数据特征
 */
trait Data
{
    protected $values;

    public function setValues( array $values ) {
        $this->values = $values;
    }

    public function getValues( ) {
        return $this->values;
    }

    public function isSet( string $key ) {
        return \array_key_exists( $key, $this->values );
    }

    public function __set( $name, $value ) {
        $this->values[ $name ] = $value;
    }

    public function __get( $name ) {
        if( !$this->isSet( $name ) ) {
            return null;
        }

        return $this->getValues()[ $name ];
    }

    public function __isset( $name ) {
        return $this->isSet( $name );
    }

    public function __unset( $name ) {
        if( $this->isSet( $name ) ) unset( $this->values[ $name ] );
    }

    public function __toString( ) {
        return \json_encode( $this->getValues(), 256 );
    }
}
