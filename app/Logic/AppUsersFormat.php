<?php
namespace App\Logic;

/**
 * 应用用户数据格式逻辑
 */
class AppUsersFormat 
{
    static public $channel_list = [
        'init' => 0, //初始化
        'natural' => 1,
        'byte' => 2,
    ];

    static public $site_list = [
        'byte' => [
            1 => '今日头条',
            10001 => '西瓜视频',
            30001 => '火山小视频',
            40001 => '抖音',
            800000000 => '穿山甲开屏广告',
            900000000 => '穿山甲网盟非开屏广告',
        ]
    ];

    static public $type_list = [
        'byte' => [
            2 => '小图模式',
            3 => '大图模式',
            4 => '组图模式',
            5 => '视频',
        ]
    ];

    static public $os_list = [
        'android' => 0,
        'ios' => 1,
        'other' => 10
    ];

    static public function fromByteClickData( array $data ) {
        $to_data = [];

        $to_data['unique_id'] = $data['unique_id'];

        $to_data['channel'] = static::$channel_list['byte'];

        return $to_data;
    }

    static public function fromInitData( array $data ) {
        $to_data = [];

        $to_data['init_id'] = $data['init_id'];
        $to_data['reg_ip'] = !empty( $data['ip'] )? $data['ip']: null;

        switch ( (int)$data['os'] ) {
            case 0:
                $to_data['os'] = static::$os_list['android'];
                break;
            case 1:
                $to_data['os'] = static::$os_list['ios'];
                break;
            
            default:
                $to_data['os'] = static::$os_list['other'];
                break;
        }

        $to_data['channel'] = static::$channel_list['init'];

        return $to_data;
    }

}
