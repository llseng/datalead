<?php
namespace App\Logic;

use DB;
use Log;
use App\BaseModel;

/**
 * 应用用户表逻辑
 */
class AppUsers
{
    protected $source_table = "game_app_users";
    protected $table;

    public function __construct( $app_id ) {
        $this->table = "ga{$app_id}_{$this->source_table}";
        if( !\in_array( $this->table, BaseModel::getCacheTables() ) ) {
            $this->create_table();
        }
    }

    protected function create_table() {
        return BaseModel::copyTableStruct( $this->source_table, $this->table );
    }

    public function delete_table() {
        return BaseModel::dropTable( $this->table );
    }

    public function create_user( $unique_id, $data ) {
        //开启事务
        DB::beginTransaction();

            try {
                $user = DB::table( $this->table )->select( 'unique_id' )->where('unique_id', $unique_id)->lockForUpdate()->first(); //写锁
                if( $user ) goto COMMIT;

                $insert_data = [
                    'unique_id' => $unique_id,
                    'reg_ip' => $data['ip'],
                    'os' => $data['os'],
                    'channel' => $data['channel'],
                    'create_date' => DB::raw('current_date()'),
                    'create_time' => DB::raw('current_time()'),
                ];
                DB::table( $this->table )->insert( $insert_data );
            } catch (\Throwable $th) {
                Log::error( "[$this->table] app user insert error", [$th->getFile().':'.$th->getLine(), $th->getCode().':'.$th->getMessage()] );
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
