<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GammAppConfig extends Model
{
    static public function configsByAppId( $id ) {
        return static::where( 'app_id', $id )->select();
    }
}
