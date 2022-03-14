<?php

namespace App\Logic\AppData\Click\Callback;

use App\Logic\AppClickData as ACDLogic;

/**
 * 华为
 */
class HuaweiStrategy implements Strategy
{
    //激活
    public function init( array $data ) {
        $other_data = \json_decode( $data['other'], true );
        return [
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
    }

    //注册
    public function register( array $data ) {
        $ACDL = new ACDLogic( $data['app_id'] );
        $click_data = $ACDL->getTableModelObj()->select([
            'aid', 'gid', 'oaid', 'ip', 'other' 
        ])->where( 'unique_id', $data['unique_id'])->first()->toArray();

        $other_data = \json_decode( $click_data['other'], true );

        return [
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
    }

    //次留
    public function keep2( array $data ) {
        $ACDL = new ACDLogic( $data['app_id'] );
        $click_data = $ACDL->getTableModelObj()->select([
            'aid', 'gid', 'oaid', 'ip', 'other' 
        ])->where( 'unique_id', $data['unique_id'])->first()->toArray();

        $other_data = \json_decode( $click_data['other'], true );

        return [
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
    }

    //关键行为
    public function cruxAction( array $data ) {
        $ACDL = new ACDLogic( $data['app_id'] );
        $click_data = $ACDL->getTableModelObj()->select([
            'aid', 'gid', 'oaid', 'ip', 'other' 
        ])->where( 'unique_id', $data['unique_id'])->first()->toArray();

        $other_data = \json_decode( $click_data['other'], true );

        return [
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
    }

}