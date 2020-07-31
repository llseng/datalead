<?php
namespace App\Logic;

use DB;
use Log;
use App\BaseModel;

/**
 * 应用基础逻辑
 */
class AppBase
{
    protected $source_table = "app_base";
    protected $table;

    public function __construct( $app_id ) {
        $this->table = "ga{$app_id}_{$this->source_table}";
        if( 
            !\in_array( $this->table, BaseModel::getCacheTables() ) 
            && !$this->create_table() 
            ) {
            throw new \Exception("Failed to create [$app_id] attached table", 1);
        }
    }

    protected function create_table() {
        return BaseModel::copyTableStruct( $this->source_table, $this->table );
    }

    public function delete_table() {
        return BaseModel::dropTable( $this->table );
    }

    public function getTable() {
        return $table;
    }

}