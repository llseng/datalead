<?php
/*
 * @Author: llseng 
 * @Date: 2020-08-03 14:41:46 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-08-03 17:39:00
 */

/**
 * 文件http请求
 *
 * @param string $url
 * @param array $context
 * @return string
 */
function file_http_request( string $url, array $http_context = null ) {
    $context = null;

    empty( $http_context ) && $http_context = [];

    $def_http_context = [
        'ignore_errors' => true,
        'timeout' => 5
    ];
    $http_context = array_merge( $def_http_context, $http_context );
    $context = stream_context_create( $http_context );

    $result = @file_get_contents( $url, null, $context );

    return $result;
}