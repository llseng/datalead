<?php
namespace App\Logic;

/**
 * 应用用户唯一id逻辑
 */
class AppUsersUid
{
    static public function fromByteClickData( array $data ) {
        $unique_id;
        $os = empty( $data['os'] )? 0: (int)$data['os'];

        switch ( $os ) {
            case 0:
                //安卓
                if( !empty( $data['imei'] ) ) {
                    $unique_id = $data['imei'];
                }elseif ( !empty( $data['oaid'] ) ) {
                    $unique_id = $data['oaid'];
                }elseif ( !empty( $data['androidid'] ) ) {
                    $unique_id = $data['androidid'];
                }
                // elseif ( !empty( $data['mac'] ) ) {
                //     $unique_id = $data['mac'];
                // }
                
                break;

            case 1:
                //ios
                if( !empty( $data['imei'] ) ) {
                    $unique_id = $data['imei'];
                }elseif( !empty( $data['idfa'] ) ) {
                    $unique_id = $data['idfa'];
                }
                // elseif ( !empty( $data['mac'] ) ) {
                //     $unique_id = $data['mac'];
                // }
                
                break;
            
            default:
                //其他
                if( !empty( $data['imei'] ) ) {
                    $unique_id = $data['imei'];
                }
                // elseif ( !empty( $data['mac'] ) ) {
                //     $unique_id = $data['mac'];
                // }
                
                break;
        }
        
        if( empty( $unique_id ) ) {
            $uni_str = '';
            if( !empty( $data['ua'] ) ) $uni_str .= md5( $data['ua'] );
            if( !empty( $data['ip'] ) ) $uni_str .= $data['ip'];

            $unique_id = md5( $uni_str );
        }

        return $unique_id;
    }

    static public function fromBtyeShowData( array $data ) {
        $unique_id;
        switch ( (int)$data['os'] ) {
            case 0:
                //安卓
                if( !empty( $data['imei'] ) ) {
                    $unique_id = $data['imei'];
                }elseif ( !empty( $data['androidid'] ) ) {
                    $unique_id = $data['androidid'];
                }
                // elseif ( !empty( $data['mac'] ) ) {
                //     $unique_id = $data['mac'];
                // }
                break;

            case 1:
                //ios
                if( !empty( $data['imei'] ) ) {
                    $unique_id = $data['imei'];
                }elseif( !empty( $data['idfa'] ) ) {
                    $unique_id = $data['idfa'];
                }
                // elseif ( !empty( $data['mac'] ) ) {
                //     $unique_id = $data['mac'];
                // }
                break;
            
            default:
                //其他
                if( !empty( $data['imei'] ) ) {
                    $unique_id = $data['imei'];
                }
                // elseif ( !empty( $data['mac'] ) ) {
                //     $unique_id = $data['mac'];
                // }
                break;
        }
        
        if( empty( $unique_id ) ) {
            $uni_str = '';
            if( !empty( $data['ua'] ) ) $uni_str .= md5( $data['ua'] );
            if( !empty( $data['ip'] ) ) $uni_str .= $data['ip'];

            $unique_id = md5( $uni_str );
        }

        return $unique_id;
    }
    
}
