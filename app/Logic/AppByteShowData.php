<?php
namespace App\Logic;

use DB;
use Log;

/**
 * 应用字节点击数据
 */
class AppByteShowData extends AppBase
{
    protected $source_table = "byte_show_data";

    public function create( $data ) {
        
        $insert_data = [
            'unique_id'=> $data['unique_id'],
            'aid'=> $data['aid'],
            'cid'=> $data['cid'],
            'csite'=> $data['csite'],
            'campaign_id'=> $data['campaign_id'],
            'os'=> $data['os'],
            'mac'=> $data['mac'],
            'ip'=> $data['ip'],
            'ts'=> $data['ts'],

            'create_date' => DB::raw('current_date()'),
            'create_time' => DB::raw('current_time()'),
        ];

        !empty( $data['imei'] ) && $insert_data['imei'] = $data['imei'];
        !empty( $data['idfa'] ) && $insert_data['idfa'] = $data['idfa'];
        !empty( $data['androidid'] ) && $insert_data['androidid'] = $data['androidid'];

        !empty( $data['ua'] ) && $insert_data['ua'] = $data['ua'];
        !empty( $data['callback_url'] ) && $insert_data['callback_url'] = $data['callback_url'];
        !empty( $data['callback_param'] ) && $insert_data['callback_param'] = $data['callback_param'];

        try {
            return DB::table( $this->table )->insert( $insert_data );
        } catch (\Throwable $th) {
            Log::error( static::class .': '. $th->getMessage() );
        }
        
        return false;
    }

}
