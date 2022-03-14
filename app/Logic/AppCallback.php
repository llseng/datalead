<?php
namespace App\Logic;

use App\GameAppCallback as GACM;

/**
 * 应用回调记录
 */
class AppCallback
{
    /**
     * 创建回调记录
     *
     * @param string $appid
     * @param string $url
     * @param array $query
     * @return bool
     */
    static public function create( string $appid, string $url, string $query, $type = null, array $head = null ) {
        $M = new GACM;
        $M->appid = $appid;
        $M->url = $url;
        if( !empty( $query ) ) $M->query = $query;
        if( !empty( $type ) ) $M->type = (int)$type;
        if( !empty( $head ) ) $M->head = \json_encode( $head );

        $status = $M->save();
        
        return $status;
    }

    static public function update( $id, string $res ) {
        $M = GACM::find( $id );
        if( empty( $M ) ) return false;
        
        $M->res = $res;
        $M->status = 1;

        $status = $M->save();
        
        return $status;
    }

}
