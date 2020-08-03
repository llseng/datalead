<?php
namespace App\Logic;

/**
 * 数据过滤
 */
class AppDataFilter 
{
    const EMPTY_REP_STR = "empty";

    static public function empty( $data ) {
        return empty( $data ) || $data == static::EMPTY_REP_STR;
    }

    static public function filterByteData( $data, $rep_str = null ) {
        $reg = "/^__\w+__$/";
        \is_null( $rep_str ) && $rep_str = static::EMPTY_REP_STR;
        return \preg_replace( $reg, $rep_str, $data );
    }

}
