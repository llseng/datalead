<?php
namespace App\Logic;

use DB;
use Log;
use App\GameAppUsers as TableModel;

/**
 * 应用用户表逻辑
 */
class AppUsers extends AppBase
{
    protected $source_table = "game_app_users";
    protected $model_class = TableModel::class;

    public function create( $data ) {
        // if( !isset( $data['init_id'] ) ) {
        if( empty( $data['init_id'] ) ) {
            Log::error( static::class .': init_id empty' );
            return false;
        }

        if( !isset( $data['os'] ) ) {
            $data['os'] = AppUsersFormat::$os_list['other'];
        }

        return parent::create( $data );
    }

    public function getUserByInitId( $init_id, $updateLock = false ) {
        $db_model = DB::table( $this->table )->select( 'init_id', 'unique_id', 'create_date' )->where('init_id', $init_id);
        if( $updateLock ) $db_model->lockForUpdate(); //写锁

        return $db_model->first();
    }

    public function only_create( $data, &$user ) {
        if( empty( $data['init_id'] ) ) {
            Log::error( static::class .': init_id empty' );
            return false;
        }
        //开启事务
        DB::beginTransaction();

            try {
                $user = $this->getUserByInitId( $data['init_id'], true );
                if( $user ) {
                    goto COMMIT;
                }
                $create_status = static::create( $data );
                if( !$create_status ) {
                    goto ROLLBACK;
                }
            } catch (\Throwable $th) {
                Log::error( static::class .': '. $th->getMessage() );
                goto ROLLBACK;
            }

        if( 0 ) {
            ROLLBACK: {
                //回滚事务
                DB::rollBack();
                return false;
            }
        }
        
        COMMIT: {
            //提交事务
            DB::commit();
            return true;
        }
    }

}
