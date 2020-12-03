<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-13 17:12:13 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-12-03 10:17:20
 */
namespace App\Logic\AppData\Click\UrlQuery;

class ByteUrlQuery extends UrlQuery
{
    static protected $params = [
        "aid" => "__AID__",
        "cid" => "__CID__",
        "gid" => "__CAMPAIGN_ID__",
        "account_id" => "__ADVERTISER_ID__",
        "ctype" => "__CTYPE__", //创意样式
        "csite" => "__CSITE__", //广告投放位置
        "os" => "__OS__", //安卓：0 IOS：1 其他：3
        "mac" => "__MAC1__", //转换成大写字母md5
        "ip" => "__IP__",
        "ts" => "__TS__",

        "imei" => "__IMEI__", //安卓的设备 ID 的 md5
        "idfa" => "__IDFA__", //IOS 6+的设备id字段，32位
        "androidid" => "__ANDROIDID__", //安卓id原值的md5
        "oaid" => "__OAID_MD5__", //Android Q及更高版本的设备号的md5

        "convert_id" => "__CONVERT_ID__", //转化id
        "request_id" => "__REQUEST_ID__", //请求下发的id
        // "ua" => "__UA__", //填写连接时报错
        "user_agent" => "__UA__", //
        "callback_url" => "__CALLBACK_URL__",
        
        "aname" => "__AID_NAME__",
        "cname" => "__CID_NAME__",
        "gname" => "__CAMPAIGN_NAME__",
    ];
}
