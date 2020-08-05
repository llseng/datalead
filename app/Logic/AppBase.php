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
    static protected $url_query = [];

    static public function getUrlQuery() {
        return \http_build_query( static::$url_query );
    }

    protected $source_table = "app_base";
    protected $table;
    protected $model_class;

    public function __construct( $app_id ) {
        $this->table = "ga_{$app_id}_{$this->source_table}";
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
        return $this->table;
    }

    public function setTableModel( string $model_class ) {
        $this->model_class = $model_class;
        return true;
    }

    public function getTableModel( ) {
        return $this->model_class;
    }

    public function create( $data ) {
        $time_data = [
            'create_date' => DB::raw('current_date()'),
            'create_time' => DB::raw('current_time()'),
        ];
        $insert_data = \array_merge( $time_data, $data );

        try {
            $TableModelClass = $this->getTableModel();
            $TableModel = new $TableModelClass;
            $TableModel->setTable( $this->table );
            $fill_status = $TableModel->fill( $insert_data )->save();
            return $fill_status;
        } catch (\Throwable $th) {
            Log::error( static::class .': '. $th->getMessage() );
        }
        
        return false;

    }

}