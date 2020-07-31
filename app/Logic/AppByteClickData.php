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

    public function create( $data ) {
        
        $insert_data = [
            'unique_id'=> $data['unique_id'],
            'aid'=> $data['aid'],
            'cid'=> $data['cid'],
            'campaign_id'=> $data['campaign_id'],
            'ctype'=> $data['ctype'],
            'csite'=> $data['csite'],
            'os'=> $data['os'],
            'mac'=> $data['mac'],
            'ip'=> $data['ip'],
            'ts'=> $data['ts'],

            'create_date' => DB::raw('current_date()'),
            'create_time' => DB::raw('current_time()'),
        ];

        !empty( $data['convert_id'] ) && $insert_data['convert_id'] = $data['convert_id'];
        !empty( $data['request_id'] ) && $insert_data['request_id'] = $data['request_id'];
        !empty( $data['imei'] ) && $insert_data['imei'] = $data['imei'];
        !empty( $data['idfa'] ) && $insert_data['idfa'] = $data['idfa'];
        !empty( $data['androidid'] ) && $insert_data['androidid'] = $data['androidid'];
        !empty( $data['oaid'] ) && $insert_data['oaid'] = $data['oaid'];


        try {
            return DB::table( $this->table )->insert( $insert_data );
        } catch (\Throwable $th) {
            Log::error( static::class .': '. $th->getMessage() );
        }
        
        return false;

    }

}
