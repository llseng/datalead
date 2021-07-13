<?php
namespace App\Logic;

use App\GameAppUserAction as TableModel;
/**
 * 应用初始化逻辑
 */
class AppUserAction extends AppBase
{
    protected $source_table = "game_app_user_action";
    protected $model_class = TableModel::class;
}
