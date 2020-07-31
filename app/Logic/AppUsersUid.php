<?php
namespace App\Logic;

/**
 * 应用用户唯一id逻辑
 */
class AppUsersUid
{
    static public function fromByteClickData( array $data ) {
        $unique_id;
        switch ( (int)$data['os'] ) {
            case 0:
                //安卓
                if( $data['androidid'] ) {
                    $unique_id = $data['androidid'];
                }elseif ( $data['oaid'] ) {
                    $unique_id = $data['oaid'];
                }elseif ( $data['imei'] ) {
                    $unique_id = $data['imei'];
                }else{
                    $unique_id = $data['max'];
                }
                break;

            case 1:
                //ios
                if( $data['idfa'] ) {
                    $unique_id = $data['idfa'];
                }else{
                    $unique_id = $data['max'];
                }
                break;
            
            default:
                //其他
                $unique_id = $data['max'];
                break;
        }

        return $unique_id;
    }

    static public function fromBtyeShowData( array $data ) {
        $unique_id;
        switch ( (int)$data['os'] ) {
            case 0:
                //安卓
                if( $data['androidid'] ) {
                    $unique_id = $data['androidid'];
                }elseif ( $data['imei'] ) {
                    $unique_id = $data['imei'];
                }else{
                    $unique_id = $data['max'];
                }
                break;

            case 1:
                //ios
                if( $data['idfa'] ) {
                    $unique_id = $data['idfa'];
                }else{
                    $unique_id = $data['max'];
                }
                break;
            
            default:
                //其他
                $unique_id = $data['max'];
                break;
        }

        return $unique_id;
    }
    
}