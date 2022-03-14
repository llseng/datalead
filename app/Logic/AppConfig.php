<?php
namespace App\Logic;

use Cache;
use App\GameAppConfig;

/**
 * 应用配置
 */
class AppConfig
{
    const CACHE_PREFIX = 'app_config_';
    const CACHE_EXPIRE_TIME = 600;
    
    static public function _key( $app_id ) {
        return static::CACHE_PREFIX. $app_id;
    }

    static public function getConfigs( $app_id ) {
        return Cache::remember( static::_key( $app_id ), static::CACHE_EXPIRE_TIME , function ()use( $app_id ) {
            $list = [];
            $result = GameAppConfig::configsByAppId( $app_id )->toArray();
            if( $result ) {
                $list = array_column( $result, 'data', 'name' );
            }
            return $list;
        });
    }

    static public function FreshConfigs( $app_id ) {
        return Cache::forget( static::_key( $app_id ) );
    } 
}
