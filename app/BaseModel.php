<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class BaseModel extends Model
{
    /**
     * 获取数据表
     *
     * @param string $like
     * @return array
     */
    static public function showTables( string $like = null ) {
        $sql = "SHOW TABLES";
        $column_key = "Tables_in_". env( 'DB_DATABASE' );
        if( $like ) {
            $sql .= " LIKE '$like'";
            $column_key .= " ($like)";
        }
        
        $tables = DB::select( $sql );
        if( empty( $tables ) ) return [];

        $list = \array_column( $tables, $column_key );

        return $list;
    }

    /**
     * 数据表是否存在
     *
     * @param string $table_name
     * @return bool
     */
    static public function existsTable( string $table_name ) {
        if( empty( $table_name ) ) return false;
        $table_name = \str_replace( ['_', '%'], ['\_', '\%'], $table_name );

        $tables = static::showTables( $table_name );
        if( empty( $tables ) ) return false; 

        return true;
    }

    static public $cache_tables_key = "db_tables";

    /**
     * 获取缓存表列表
     *
     * @return array
     */
    static public function getCacheTables() {
        return \cache()->remember( static::$cache_tables_key, 10080, function() {
            return static::showTables();
        } );
    }

    /**
     * 刷新表列表缓存
     *
     * @return bool
     */
    static public function flushCacheTables() {
        return \cache()->forget( static::$cache_tables_key );
    }

    /**
     * 复制表结构
     *
     * @param string $source 源表
     * @param string $dest 目标表
     * @return bool
     */
    static public function copyTableStruct( string $source, string $dest ) {
        if( 
            static::existsTable( $dest ) 
            || !static::existsTable( $source ) 
        ) return false;

        $copy_sql = "CREATE TABLE $dest LIKE $source";

        try {
            $copy_status = DB::statement( $copy_sql );
        } catch (\Throwable $th) {
            $copy_status = false;
        }

        if( $copy_status ) {
            static::flushCacheTables();
        }

        return $copy_status;
    }

    static public function dropTableIfExists( string $table ) {
        $drop_sql = "DROP TABLE IF EXISTS $table";
        $drop_status = DB::statement( $drop_sql );
        
        if( $drop_status ) {
            static::flushCacheTables();
        }

        return $drop_status;
    }

    static public function dropTable( string $table ) {
        return static::dropTableIfExists( $table );
    }
}
