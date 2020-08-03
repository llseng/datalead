<?php
namespace App\Logic;

use DB;
use Log;

/**
 * 应用字节点击数据
 */
class AppByteClickData extends AppBase
{
    protected $source_table = "byte_click_data";

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
        "callback_url" => "__CALLBACK_URL__",
        "callback_param" => "__CALLBACK_PARAM__",
    ];

    public function create( $data ) {
        
        $insert_data = [
            'unique_id'=> $data['unique_id'],
            'aid'=> $data['aid'],
            'cid'=> $data['cid'],
            'campaign_id'=> $data['campaign_id'],
            'advertiser_id'=> $data['advertiser_id'],
            'ctype'=> $data['ctype'],
            'csite'=> $data['csite'],
            'os'=> $data['os'],
            'mac'=> $data['mac'],
            'ip'=> $data['ip'],
            'ts'=> (int)$data['ts'],

            'create_date' => DB::raw('current_date()'),
            'create_time' => DB::raw('current_time()'),
        ];

        !empty( $data['convert_id'] ) && !AppDataFilter::empty( $data['convert_id'] ) && $insert_data['convert_id'] = $data['convert_id'];
        !empty( $data['request_id'] ) && !AppDataFilter::empty( $data['request_id'] ) && $insert_data['request_id'] = $data['request_id'];
        !empty( $data['imei'] ) && !AppDataFilter::empty( $data['imei'] ) && $insert_data['imei'] = $data['imei'];
        !empty( $data['idfa'] ) && !AppDataFilter::empty( $data['idfa'] ) && $insert_data['idfa'] = $data['idfa'];
        !empty( $data['androidid'] ) && !AppDataFilter::empty( $data['androidid'] ) && $insert_data['androidid'] = $data['androidid'];
        !empty( $data['oaid'] ) && !AppDataFilter::empty( $data['oaid'] ) && $insert_data['oaid'] = $data['oaid'];

        !empty( $data['ua'] ) && !AppDataFilter::empty( $data['ua'] ) && $insert_data['ua'] = \substr( $data['ua'], 0, 100 );
        !empty( $data['callback_url'] ) && !AppDataFilter::empty( $data['callback_url'] ) && $insert_data['callback_url'] = $data['callback_url'];
        !empty( $data['callback_param'] ) && !AppDataFilter::empty( $data['callback_param'] ) && $insert_data['callback_param'] = $data['callback_param'];


        try {
            return DB::table( $this->table )->insert( $insert_data );
        } catch (\Throwable $th) {
            Log::error( static::class .': '. $th->getMessage() );
        }
        
        return false;

    }

}
