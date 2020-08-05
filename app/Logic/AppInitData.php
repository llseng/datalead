<?php
namespace App\Logic;

use App\GameAppInitData as TableModel;
/**
 * 应用初始化逻辑
 */
class AppInitData extends AppBase
{
    protected $source_table = "game_app_init_data";
    protected $model_class = TableModel::class;
    
}
