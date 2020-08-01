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
    static public function create( string $appid, string $url, array $query ) {
        $M = new GACM;
        $M->appid = $appid;
        $M->url = $url;
        if( !empty( $query ) ) $M->query = \http_build_query( $query );

        $status = $M->save();
        
        return $status;
    }
}
