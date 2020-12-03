<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-13 15:10:48 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-11-16 14:23:32
 */

namespace App\Logic\AppData\Click;

use App\Logic\AppData\Data as AppData;

/**
 * undocumented class
 */
abstract class Data
{
    use AppData;

    const PLATFORM_ID = 0;

    public function __construct( array $values ) {
        $this->setValues( $values );
    }

    /**
     * 平台id
     *
     * @return int
     */
    public function getPlatformId() {
        return static::PLATFORM_ID;
    }

    /**
     * 设备唯一id
     *
     * @return string
     */
    public function getUniqueId() {
        $unique_id;

        switch ( (int)$this->getOs() ) {
            case 0:
                //安卓
                if( $this->getImei() ) {
                    $unique_id = $this->getImei();
                }elseif ( $this->getOaid() ) {
                    $unique_id = $this->getOaid();
                }elseif ( $this->getAndroidid() ) {
                    $unique_id = $this->getAndroidid();
                }
                
                break;

            case 1:
                //ios
                if( $this->getImei() ) {
                    $unique_id = $this->getImei();
                }elseif( $this->getIdfa() ) {
                    $unique_id = $this->getIdfa();
                }
                
                break;
            
            default:
                //其他
                if( $this->getImei() ) {
                    $unique_id = $this->getImei();
                }
                
                break;
        }
        
        if( empty( $unique_id ) ) {
            $uni_str = '';
            if( $this->getMac() ) $uni_str .= $this->getMac();
            if( $this->getIp() ) $uni_str .= $this->getIp();
            if( $this->getUa() ) $uni_str .= md5( $this->getUa() );

            $unique_id = md5( $uni_str );
        }

        return $unique_id;
    }

    //点击ID
    abstract public function getClickId();
    //计划ID
    abstract public function getAid();
    //创意ID
    abstract public function getCid();
    //组ID
    abstract public function getGid();
    //账户ID
    abstract public function getAccountId();
    //imei_MD5
    abstract public function getImei();
    //ios_idfa_MD5
    abstract public function getIdfa();
    //androidid_MD5
    abstract public function getAndroidid();
    //oaid_MD5
    abstract public function getOaid();
    //mac_upper_MD5
    abstract public function getMac();
    abstract public function getIp();
    //设备类型
    abstract public function getOs();
    //毫秒
    abstract public function getTs();
    //user_agent
    abstract public function getUa();
    //callback_url
    abstract public function getCallbackUrl();
    //补充数据
    abstract public function getOther();

    public function getData( ) {
        return [
            'unique_id' => $this->getUniqueId(),
            'platform_id' => $this->getPlatformId(),
            'click_id' => $this->getClickId(),
            'aid' => $this->getAid(),
            'cid' => $this->getCid(),
            'gid' => $this->getGid(),
            'account_id' => $this->getAccountId(),
            'imei' => $this->getImei(),
            'idfa' => $this->getIdfa(),
            'androidid' => $this->getAndroidid(),
            'oaid' => $this->getOaid(),
            'mac' => $this->getMac(),
            'ip' => $this->getIp(),
            'os' => $this->getOs(),
            'ts' => $this->getTs(),
            'ua' => $this->getUa(),
            'callback_url' => $this->getCallbackUrl(),
            'other' => $this->getOther(),
        ];
    }
}
