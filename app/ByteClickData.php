<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ByteClickData extends Model
{
    //字段白名单
    protected $fillable = [
        'unique_id',
        'aid',
        'cid',
        'advertiser_id',
        'campaign_id',
        'convert_id',
        'ctype',
        'csite',
        'request_id',
        'imei',
        'idfa',
        'androidid',
        'oaid',
        'os',
        'mac',
        'ip',
        'ua',
        'ts',
        // 'callback_param',
        'callback_url',
        'create_date',
        'create_time'
    ];
    
    public $timestamps = false;
}
