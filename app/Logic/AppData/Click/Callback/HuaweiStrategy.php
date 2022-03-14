<?php

namespace App\Logic\AppData\Click\Callback;

use App\Logic\AppClickData as ACDLogic;
use App\Logic\AppConfig as ACLogic;
use App\Logic\AppCallback as AppCallbackL;

/**
 * 华为
 */
class HuaweiStrategy implements Strategy
{
    const CALLBACK_URL = 'https://ppscrowd-drcn.op.hicloud.com/action-lib-track/hiad/v2/actionupload';

    //激活
    public function init( array $data ) {
        $other_data = \json_decode( $data['other'], true );
        $res = [
            'content_id' => $data['aid'],
            'campaign_id' => $data['gid'],
            'oaid' => $data['oaid'],
            'ip' => $data['ip'],

            'callback' => $other_data['callback'],
            'tracking_enabled' => $other_data['tracking'],
            'conversion_time' => $other_data['trace_time'],
            'timestamp' => round( \microtime( true ) * 1000 ),
            
            'conversion_type' => 'activate',
        ];

        return $this->create_callback( $data['app_id'], $res );
    }

    //注册
    public function register( array $data ) {
        $ACDL = new ACDLogic( $data['app_id'] );
        $click_data = $ACDL->getTableModelObj()->select([
            'aid', 'gid', 'oaid', 'ip', 'other' 
        ])->where( 'click_id', $data['click_id'])->first()->toArray();

        $other_data = \json_decode( $click_data['other'], true );

        $res = [
            'content_id' => $click_data['aid'],
            'campaign_id' => $click_data['gid'],
            'oaid' => $click_data['oaid'],
            'ip' => $click_data['ip'],

            'callback' => $other_data['callback'],
            'tracking_enabled' => $other_data['tracking'],
            'conversion_time' => \time(),
            'timestamp' => \round( \microtime( true ) * 1000 ),
            
            'conversion_type' => 'register',
        ];

        return $this->create_callback( $data['app_id'], $res );
    }

    //次留
    public function keep2( array $data ) {
        $ACDL = new ACDLogic( $data['app_id'] );
        $click_data = $ACDL->getTableModelObj()->select([
            'aid', 'gid', 'oaid', 'ip', 'other' 
        ])->where( 'click_id', $data['click_id'])->first()->toArray();

        $other_data = \json_decode( $click_data['other'], true );

        $res = [
            'content_id' => $click_data['aid'],
            'campaign_id' => $click_data['gid'],
            'oaid' => $click_data['oaid'],
            'ip' => $click_data['ip'],

            'callback' => $other_data['callback'],
            'tracking_enabled' => $other_data['tracking'],
            'conversion_time' => \time(),
            'timestamp' => \round( \microtime( true ) * 1000 ),
            
            'conversion_type' => 'retain',
        ];

        return $this->create_callback( $data['app_id'], $res );
    }

    //关键行为
    public function cruxAction( array $data ) {
        $ACDL = new ACDLogic( $data['app_id'] );
        $click_data = $ACDL->getTableModelObj()->select([
            'aid', 'gid', 'oaid', 'ip', 'other' 
        ])->where( 'click_id', $data['click_id'])->first()->toArray();

        $other_data = \json_decode( $click_data['other'], true );

        $res = [
            'content_id' => $click_data['aid'],
            'campaign_id' => $click_data['gid'],
            'oaid' => $click_data['oaid'],
            'ip' => $click_data['ip'],

            'callback' => $other_data['callback'],
            'tracking_enabled' => $other_data['tracking'],
            'conversion_time' => \time(),
            'timestamp' => round( \microtime( true ) * 1000 ),
            
            'conversion_type' => 'custom',
        ];

        return $this->create_callback( $data['app_id'], $res );
    }

    private function create_callback( $app_id, $data ) {
        $key = static::getAppHuaweiKey( $app_id );
        $query = static::buildRequestBody( $data );
        $auto_head = static::buildAuthorizationHeader( $query, $key );
        $heads = [
            'Content-Type: application/json; charset=UTF-8',
            $auto_head
        ];

        return AppCallbackL::create( $app_id, self::CALLBACK_URL, $query, 1, $heads );
    }

    static public function getAppHuaweiKey( $app_id ) {
        $app_configs = ACLogic::getConfigs( $app_id );
        return $app_configs['huawei_secret'] ?? '';
    }

    static public function buildRequestBody( $data ) {
        return json_encode($data);
    }

    static public function buildAuthorizationHeader( $body, $key ) {
        $current_timestamp = intval(microtime(true) * 1000);
        $signature = hash_hmac('sha256', $body, $key);
        return 'Authorization: Digest validTime="' . $current_timestamp . '", response="' . 
        $signature . '"';
    }
}