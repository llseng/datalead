<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameApp extends Model
{
    protected $table = 'game_app';

    protected $keyType = 'string';

    /**
     * 所有配置记录
     *
     * @return void
     */
    public function configs() {
        return $this->hasMany( GameApp::class, 'app_id' );
    }
}
