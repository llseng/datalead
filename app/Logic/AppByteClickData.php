<?php
namespace App\Logic;

use DB;
use Log;
use App\ByteClickData as TableModel;

/**
 * 应用字节点击数据
 */
class AppByteClickData extends AppBase
{
    protected $source_table = "byte_click_data";
    protected $model_class = TableModel::class;

    static protected $url_query = [
        "aid" => "__AID__",
        "cid" => "__CID__",
        "campaign_id" => "__CAMPAIGN_ID__",
        "advertiser_id" => "__ADVERTISER_ID__",
        "ctype" => "__CTYPE__",
        "csite" => "__CSITE__",
        "os" => "__OS__",
        "mac" => "__MAC__",
        "ip" => "__IP__",
        "ts" => "__TS__",

        "imei" => "__IMEI__",
        "idfa" => "__IDFA__",
        "androidid" => "__ANDROIDID__",
        "oaid" => "__OAID__",

        "convert_id" => "__CONVERT_ID__",
        "request_id" => "__REQUEST_ID__",
        // "ua" => "__UA__", //填写连接时报错
        "user_agent" => "__UA__", //
        "callback_url" => "__CALLBACK_URL__",
        "callback_param" => "__CALLBACK_PARAM__",
    ];

    public function create( $data ) {
        
        if( !isset( $data['os'] ) ) {
            $data['os'] = 0;
        }
        
        return parent::create( $data );

    }

}
