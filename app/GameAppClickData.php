<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameAppClickData extends Model
{
    protected $fillable = [
        'unique_id',
        'platform_id',
        'aid',
        'cid',
        'gid',
        'account_id',
        'imei',
        'idfa',
        'androidid',
        'oaid',
        'mac',
        'ip',
        'os',
        'ts',
        'ua',
        'callback_url',
        'other',
        'create_date',
        'create_time',
    ];
    
    public $timestamps = false;
}
