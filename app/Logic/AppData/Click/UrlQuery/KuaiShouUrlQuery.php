<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-13 18:02:13 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-12-03 10:19:20
 */
namespace App\Logic\AppData\Click\UrlQuery;

class KuaiShouUrlQuery extends UrlQuery
{
    static protected $params = [
        "aid" => "__DID__",
        "cid" => "__CID__",
        "gid" => "__AID__",
        "account_id" => "__ACCOUNTID__",
        "os" => "__OS__",
        "mac" => "__MAC__", //原值，需要大写并且用:分割
        "ip" => "__IP__",
        "ts" => "__TS__",
        
        "csite" => "__CSITE__", //广告投放场景

        "imei" => "__IMEI2__", //对15位数字的 IMEI 进行 MD5
        "idfa" => "__IDFA2__", //iOS下的idfa计算MD5
        "androidid" => "__ANDROIDID2__", //对 ANDROIDID进行 MD5
        "oaid" => "__OAID__", //Android设备标识，原值
        
        // "ua" => "__UA__", //填写连接时报错
        "user_agent" => "__UA__", //
        "callback_url" => "__CALLBACK__", //回调信息，编码一次的URL，长度小于10k

        "aname" => "__DNAME__",
    ];
}
