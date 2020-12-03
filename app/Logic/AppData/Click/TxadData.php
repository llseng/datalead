<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-13 16:30:53 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-12-03 11:21:36
 */
namespace App\Logic\AppData\Click;

/**
 * 
 */
class TxadData extends Data
{
    const PLATFORM_ID = 3;

    //点击ID
    public function getClickId() {
        return $this->click_id;
    }

    private function is_android() {
        return $this->device_os_type == 'android';
    }

    private function is_ios() {
        return $this->device_os_type == 'ios';
    }

    //计划ID
    public function getAid() {
        return $this->campaign_id;
    }
    //创意ID
    public function getCid() {
        return $this->creative_id;
    }
    //组ID
    public function getGid() {
        return $this->adgroup_id;
    }
    //账户ID
    public function getAccountId() {
        return $this->advertiser_id;
    }
    //imei_MD5
    public function getImei() {
        return $this->is_android()? $this->muid: null;
    }
    //ios_idfa_MD5
    public function getIdfa() {
        return $this->is_ios()? $this->muid: null;
    }
    //androidid_MD5
    public function getAndroidid() {
        return $this->android_id;
    }
    //oaid_MD5
    public function getOaid() {
        return isset( $this->oaid )? \md5( $this->oaid ): null;
    }
    //mac_upper_MD5
    public function getMac() {
        return null;
    }
    public function getIp() {
        return $this->ip;
    }
    //设备类型
    public function getOs() {
        if( $this->is_android() ) {
            return 0;
        }elseif( $this->is_ios() ) {
            return 1;
        }

        return 3;
    }
    //毫秒
    public function getTs() {
        return isset( $this->click_time )? $this->click_time * 1000: \round( microtime(1) * 1000 );
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
            'aname' => $this->campaign_name,
            'cname' => $this->creative_name,
            'gname' => $this->adgroup_name,
            'click_sku_id' => $this->click_sku_id,
            'site_set' => $this->site_set,
        ];
        return \json_encode( $data, 256 );
    }
}
