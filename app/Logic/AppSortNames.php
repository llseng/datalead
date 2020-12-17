<?php
namespace App\Logic;

use DB;
use Log;
use App\GameAppSortNames as TableModel;

/**
 * 应用分类名表逻辑
 */
class AppSortNames extends AppBase
{
    protected $source_table = "game_app_sort_names";
    protected $model_class = TableModel::class;

    public function create( $data ) {
        try {
            return DB::table( $this->getTable() )->insertGetId( $data );
        } catch (\Throwable $th) {
            Log::error( static::class .': '. $th->getMessage() );
        }

        return false;
    }

    public function first( $where, $select = ['id', 'sup_id'] ) {
        try {
            return DB::table( $this->getTable() )->select( $select )->where( $where )->first();
        } catch (\Throwable $th) {
            Log::error( static::class .': '. $th->getMessage() );
        }

        return false;
    }

    public function update( $where, $data ) {
        try {
            return DB::table( $this->getTable() )->where( $where )->update( $data );
        } catch (\Throwable $th) {
            Log::error( static::class .': '. $th->getMessage() );
        }

        return false;
    }

    public function generate( $ad_data ) {
        
        $platform_where = [
            "platform_id" => $ad_data['platform_id']
        ];

        $cid_where = \array_merge( $platform_where, [
            "level" => 2,
            "sort_id" => $ad_data['cid']
        ]);
        $cid_data = $this->first( $cid_where );
        if( $cid_data ) {
            $this->update( $cid_where, [ "sort_name" => $ad_data[ 'cname' ] ] );
            return $cid_data['id']; //记录存在直接返回
        }

        $cid_insert_data = $cid_where;
        $cid_insert_data['sort_name'] = $ad_data[ 'cname' ];

        $aid_where = \array_merge( $platform_where, [
            "level" => 1,
            "sort_id" => $ad_data['aid']
        ]);
        $aid_data = $this->first( $aid_where );
        if( $aid_data ) {
            $cid_insert_data[ 'sup_id' ] = $aid_data['id'];
            $cid_insert_data[ 'sup_chain' ] = $aid_data['sup_id']. ",". $aid_data['id'];
            
            $this->update( $aid_where, [ "sort_name" => $ad_data[ 'aname' ] ] );
        }else{ //上级aid不存在
            $aid_insert_data = $aid_where;
            $aid_insert_data['sort_name'] = $ad_data[ 'aname' ];
            
            $gid_where = \array_merge( $platform_where, [
                "level" => 0,
                "sort_id" => $ad_data['gid']
            ]);
            $gid_data = $this->first( $gid_where );
            if( $gid_data ) {
                $aid_insert_data[ 'sup_id' ] = $gid_data['id'];
                $aid_insert_data[ 'sup_chain' ] = $gid_data['id'];
            
                $this->update( $gid_where, [ "sort_name" => $ad_data[ 'gname' ] ] );
            }else{ //上级gid不存在
                $gid_insert_data = $gid_where;
                $gid_insert_data['sort_name'] = $ad_data[ 'gname' ];
                $gid_id = $this->create( $gid_insert_data );
                if( !$gid_id ) return false;
                
                $aid_insert_data[ 'sup_id' ] = $gid_id;
                $aid_insert_data[ 'sup_chain' ] = $gid_id;
            }

            $aid_id = $this->create( $aid_insert_data );
            if( !$aid_id ) return false;
            $cid_insert_data[ 'sup_id' ] = $aid_id;
            $cid_insert_data[ 'sup_chain' ] = $aid_insert_data['sup_id']. ",". $aid_id;
        }

        $cid_id = $this->create( $cid_insert_data );
        if( !$cid_id ) return false;

        return $cid_id;
    }

}