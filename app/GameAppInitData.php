<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameAppInitData extends Model
{
    protected $fillable = [
        'init_id',
        'reid',
        'imei',
        'imei2',
        'meid',
        'deviceId',
        'idfa',
        'androidid',
        'oaid',
        'os',
        'mac',
        'serial',
        'manufacturer',
        'model',
        'brand',
        'device',
        'ip',
        'ipv6',
        'ua',
        'ts',
        'create_date',
        'create_time',
    ];
    
    public $timestamps = false;
}
