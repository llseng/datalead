<?php
/*
 * @Author: llseng 
 * @Date: 2020-08-03 14:41:46 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-08-25 10:35:55
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

/**
 * 标签属性转字符串
 *
 * @param array $attr
 * @return void
 */
function tagAttrToStr( array $attr ) {
    $str = "";
    foreach ($attr as $key => $val) {
        $str .= $key. '="'. $val. '" ';
    }

    return $str;
}


function http_curl( $method, $url, $query = '', $second = 10, $header = FALSE ) 
{       
    $ch = curl_init();
    $curlVersion = curl_version();
    $ua = "Datalead/1.0.0 (".PHP_OS.") PHP/".PHP_VERSION." CURL/".$curlVersion['version'];

    if( strtolower( $method ) != 'post' )
    {
        if( !empty($query) )
        {
            $join_str = "?";
            if( strpos($url, '?') !== FALSE ) $join_str .= '&';
            $url .= $join_str. $query;
        }

        curl_setopt($ch,CURLOPT_URL, $url);
    }else{

        curl_setopt($ch,CURLOPT_URL, $url);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        if( !empty($query) ) curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    }

    //设置超时
    curl_setopt($ch, CURLOPT_TIMEOUT, $second );
    
    if( stripos($url,"https://")!==FALSE ) {
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
    }else{
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
    }

    curl_setopt($ch,CURLOPT_USERAGENT, $ua); 
    //设置header
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    //运行curl
    $data = curl_exec($ch);
    //返回结果
    if($data){
        curl_close($ch);
        return $data;
    } else { 
        $error = curl_errno($ch);
        curl_close($ch);
        throw new \Exception("curl出错, 错误码:$error");
    }

}