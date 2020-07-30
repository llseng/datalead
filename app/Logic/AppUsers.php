<?php
namespace App\Logic;

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

    public function create_table() {
        return BaseModel::copyTableStruct( $this->source_table, $this->table );
    }

    public function create_user( $unique_id, $data ) {
        //开启事务
        DB::beginTransaction();
            $user = DB::table( $this->table )->select( 'unique_id' )->where('unique_id', $unique_id)->lockForUpdate()->first(); //写锁
            if( $user ) goto END;

            $update_data = [
                'unique_id' => $unique_id,
            ];

        if( 0 ) {
            END: {
                //回滚事务
                DB::rollBack();
                return false;
            }
        }
        
        //提交事务
        DB::commit();
        return true;
    }

}
