<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-13 16:30:53 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-12-03 11:21:30
 */
namespace App\Logic\AppData\Click;

/**
 * 
 */
class KuaiShouData extends Data
{
    const PLATFORM_ID = 2;

    //点击ID
    public function getClickId() {
        return $this->click_id;
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
        return $this->imei;
    }
    //ios_idfa_MD5
    public function getIdfa() {
        return $this->idfa;
    }
    //androidid_MD5
    public function getAndroidid() {
        return $this->androidid;
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
        return $this->os;
    }
    //毫秒
    public function getTs() {
        return isset( $this->ts )? $this->ts: \round( microtime(1) * 1000 );
    }
    //user_agent
    public function getUa() {
        return $this->user_agent;
    }
    //callback_url
    public function getCallbackUrl() {
        return $this->callback_url;
    }
    //补充数据
    public function getOther() {
        $data = [
            'aname' => $this->aname,
            'cname' => $this->cname,
            'gname' => $this->gname,
            'csite' => $this->csite,
        ];
        return \json_encode( $data, 256 );
    }
}
