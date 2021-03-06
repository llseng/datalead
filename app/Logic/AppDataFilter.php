<?php
namespace App\Logic;

/**
 * 数据过滤
 */
class AppDataFilter 
{
    const EMPTY_REP_STR = "empty";

    const DLIST = [ null, "" ];

    static public function empty( $data ) {
        return empty( $data ) || $data == static::EMPTY_REP_STR;
    }

    static public function filter( array $data ) {
        return \array_filter( $data, function ( $val ) {
            return !\in_array( $val, static::DLIST, true ); //使用严格模式,检查类型
        } );
    }

    static public function filterByteData( array $data, $rep_str = null ) {
        
        $reg = "/^__\w+__$/";
        $data = \preg_replace( $reg, $rep_str, $data );

        $data = static::filter( $data );

        return $data;
    }

    static public function filterKeys( array $data, array $keys ) {
        return \array_except( $data, $keys );
    }
}
