<?php
namespace App\Logic\AppData\Click;

class HuaweiData extends Data
{
    const PLATFORM_ID = 4;

    //点击ID
    public function getClickId() {
        return $this->transunique_id;
    }

    //计划ID
    public function getAid() {
        return $this->aid;
    }
    //创意ID
    public function getCid() {
        return $this->cid;
    }
    //组ID
    public function getGid() {
        return $this->gid;
    }
    //账户ID
    public function getAccountId() {
        return $this->account_id;
    }
    //imei_MD5
    public function getImei() {
        return null;
    }
    //ios_idfa_MD5
    public function getIdfa() {
        return null;
    }
    //androidid_MD5
    public function getAndroidid() {
        return null;
    }
    //oaid_MD5
    public function getOaid() {
        return isset( $this->oaid )? \md5( $this->oaid ): null;
    }
    //mac_upper_MD5
    public function getMac() {
        return isset( $this->mac )? \md5( $this->mac ): null;
    }
    public function getIp() {
        return $this->ip;
    }
    //设备类型
    public function getOs() {
        return 0;
    }
    //毫秒
    public function getTs() {
        return isset( $this->trace_time )? $this->trace_time * 1000: \round( microtime(1) * 1000 );
    }
    //user_agent
    public function getUa() {
        return $this->ua;
    }
    //callback_url
    public function getCallbackUrl() {
        return null;
    }
    //补充数据
    public function getOther() {
        $data = [
            'aname' => $this->aname,
            'cname' => $this->cname,
            'gname' => $this->gname,
            'callback' => $this->callback,
            'tracking' => $this->tracking,
            'event_type' => $this->event_type,
            'trace_time' => $this->trace_time,
            'transunique_id' => $this->transunique_id,
        ];
        return \json_encode( $data, 256 );
    }
}
