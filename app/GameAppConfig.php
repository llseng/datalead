<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameAppConfig extends Model
{
    protected $fillable = [
        'name',
        'data',
        'app_id',
        'sort',
        'intro'
    ];

    static public function configsByAppId( $id ) {
        return static::where( 'app_id', $id )->get();
    }
}
