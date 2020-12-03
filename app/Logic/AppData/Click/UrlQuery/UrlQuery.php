<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-13 16:49:34 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-11-13 17:14:05
 */
namespace App\Logic\AppData\Click\UrlQuery;

/**
 * 
 */
class UrlQuery
{
    static protected $params = [];

    static public function setAll( array $params ) {
        static::$params = $params;
    }

    static public function getAll( ) {
        return static::$params;
    }

    static public function isSet( string $key ) {
        return \array_key_exists( $key, static::getAll() );
    }

    static public function set( string $key, $value ) {
        static::$params[ $key ] = $value;
    }

    static public function get( string $key ) {
        if( !static::isSet( $key ) ) {
            return null;
        }

        return static::getAll()[ $key ];
    }

    static public function toString() {
        return \http_build_query( static::getAll() );
    }
}
