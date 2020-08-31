<?php
namespace App\Logic;

use App\GameAppInitData as TableModel;
/**
 * 应用初始化逻辑
 */
class AppInitData extends AppBase
{
    protected $source_table = "game_app_init_data";
    protected $model_class = TableModel::class;
    
    static public function InitId( array $init_data ) {
        $init_id;
        $os = empty( $init_data['os'] )? 0: (int)$init_data['os'];

        switch ( $os ) {
            case 0:
                //安卓
                if ( !empty( $init_data['reid'] ) ) {
                    $init_id = $init_data['reid']; //应用初始化生成的ID
                }elseif( !empty( $init_data['imei'] ) ) {
                    $init_id = $init_data['imei'];
                }elseif ( !empty( $init_data['androidid'] ) ) {
                    $init_id = $init_data['androidid'];
                }elseif ( !empty( $init_data['oaid'] ) ) {
                    $init_id = $init_data['oaid'];
                }
                
                break;

            case 1:
                //ios
                if ( !empty( $init_data['reid'] ) ) {
                    $init_id = $init_data['reid'];
                }elseif( !empty( $init_data['imei'] ) ) {
                    $init_id = $init_data['imei'];
                }elseif( !empty( $init_data['idfa'] ) ) {
                    $init_id = $init_data['idfa'];
                }
                
                break;
            
            default:
                //其他
                if ( !empty( $init_data['reid'] ) ) {
                    $init_id = $init_data['reid'];
                }elseif( !empty( $init_data['imei'] ) ) {
                    $init_id = $init_data['imei'];
                }
                
                break;
        }
        
        if( empty( $init_id ) ) {
            $uni_str = '';
            if( !empty( $init_data['mac'] ) ) $uni_str .= $init_data['mac'];
            if( !empty( $init_data['ip'] ) ) $uni_str .= $init_data['ip'];
            if( !empty( $init_data['ua'] ) ) $uni_str .= md5( $init_data['ua'] );

            $init_id = md5( $uni_str );
        }

        return $init_id;

    }

    public function create( $data ) {
        if( empty( $data['init_id'] ) ) {
            return false;
        }

        if( empty( $data['ip'] ) && !empty( $data['ipv6'] ) ) {
            $data['ip'] = $data['ipv6'];
        }

        return parent::create( $data );
    }

}
