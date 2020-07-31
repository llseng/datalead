<?php
namespace App\Logic;

use DB;
use Log;

/**
 * 应用用户表逻辑
 */
class AppUsers extends AppBase
{
    protected $source_table = "game_app_users";

    public function create( $data ) {
        //开启事务
        DB::beginTransaction();

            try {
                $user = DB::table( $this->table )->select( 'unique_id' )->where('unique_id', $data['unique_id'])->lockForUpdate()->first(); //写锁
                if( $user ) goto COMMIT;

                $insert_data = \array_merge( $data, [
                    'create_date' => DB::raw('current_date()'),
                    'create_time' => DB::raw('current_time()'),
                ]);
                DB::table( $this->table )->insert( $insert_data );
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
