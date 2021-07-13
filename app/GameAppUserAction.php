<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameAppUserAction extends Model
{
    protected $fillable = [
        'init_id',
        'type',
        'content',
        'create_date',
        'create_time',
    ];
    
    public $timestamps = false;
}
