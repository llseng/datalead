<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameAppUsers extends Model
{
    //字段白名单
    protected $fillable = [
        'unique_id',
        'reg_ip',
        'os',
        'channel',
        'create_date',
        'create_time'
    ];
    
    public $timestamps = false;
}
