<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-13 16:30:53 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-12-03 11:21:50
 */
namespace App\Logic\AppData\Click;

/**
 * 
 */
class ByteData extends Data
{
    const PLATFORM_ID = 1;

    //点击ID
    public function getClickId() {
        return $this->request_id;
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
        return isset( $this->idfa )? \md5( $this->idfa ): null;
    }
    //androidid_MD5
    public function getAndroidid() {
        return $this->androidid;
    }
    //oaid_MD5
    public function getOaid() {
        return $this->oaid;
    }
    //mac_upper_MD5
    public function getMac() {
        return $this->mac;
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
            'ctype' => $this->ctype,
            'csite' => $this->csite,
            'convert_id' => $this->convert_id,
        ];
        return \json_encode( $data, 256 );
    }
}
