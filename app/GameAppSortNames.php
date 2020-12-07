<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameAppSortNames extends Model
{
    //字段白名单
    protected $fillable = [
        'sup_id',
        'platform_id',
        'level',
        'sort_id',
        'sort_name',
        'sup_chain',
    ];
}
