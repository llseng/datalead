<?php
namespace App\Logic;

use DB;
use Log;
use App\ByteShowData as TableModel;

/**
 * 应用字节点击数据
 */
class AppByteShowData extends AppBase
{
    protected $source_table = "byte_show_data";
    protected $model_class = TableModel::class;

    static protected $url_query = [
        "aid" => "__AID__",
        "cid" => "__CID__",
        "campaign_id" => "__CAMPAIGN_ID__",
        "csite" => "__CSITE__",
        "os" => "__OS__",
        "mac" => "__MAC__",
        "ip" => "__IP__",
        "ts" => "__TS__",

        "imei" => "__IMEI__",
        "idfa" => "__IDFA__",
        "androidid" => "__ANDROIDID__",
        
        "ua" => "__UA__",
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
