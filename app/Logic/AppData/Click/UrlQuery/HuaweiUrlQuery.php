<?php

namespace App\Logic\AppData\Click\UrlQuery;
/**
 * 华为
 */
class HuaweiUrlQuery extends UrlQuery
{
    static protected $params = [
        "aid" => "{content_id}",
        "cid" => "{adgroup_id}",
        "gid" => "{campaign_id}",
        "account_id" => "{corp_id}",
        "oaid" => "{oaid}",
        "ip" => "{ip}",
        "ua" => "{user_agent}",

        "callback" => "{callback}",
        "tracking" => "{tracking_enabled}",
        "event_type" => "{event_type}",
        "trace_time" => "{trace_time}",
        "transunique_id" => "{transunique_id}",
        
        "aname" => "{content_name}",
        "cname" => "{adgroup_name}",
        "gname" => "{campaign_name}",
    ];

    static public function toString() {
        return \urldecode( parent::toString() );
    }
}
