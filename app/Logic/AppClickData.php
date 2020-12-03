<?php
namespace App\Logic;

use DB;
use Log;
use App\GameAppClickData as TableModel;

use App\Logic\AppData\Click\Data as ClickData;

/**
 * 应用广告点击表逻辑
 */
class AppClickData extends AppBase
{
    protected $source_table = "game_app_click_data";
    protected $model_class = TableModel::class;

    public function create( $data ) {
        
        $time_data = [
            'create_date' => date( "Y-m-d", \round( $data['ts'] / 1000 ) ),
            'create_time' => date( "H:i:s", \round( $data['ts'] / 1000 ) ),
        ];
        $insert_data = \array_merge( $time_data, $data );

        try {
            $TableModel = $this->getTableModelObj();
            $fill_status = $TableModel->fill( $insert_data )->save();
            return $fill_status;
        } catch (\Throwable $th) {
            Log::error( static::class .': '. $th->getMessage() );
        }
        
        return false;
    }

    public function clickIdExists( $platform_id, $click_id ) {
        try {
            $TableModel = $this->getTableModelObj();
            $id = $TableModel->where( 'platform_id', $platform_id )->where( 'click_id', $click_id )->value('id');
            return $id ? true: false;
        } catch (\Throwable $th) {
            Log::error( static::class .': '. $th->getMessage() );
        }

        return false;
    }

    public function createByClickData( ClickData $ClickData ) {
        //点击id存在时无需写入
        if( $ClickData->getClickId() && $this->clickIdExists( $ClickData->getPlatformId(), $ClickData->getClickId() ) ) {
            return true;
        }

        return $this->create( $ClickData->getData() );
    }

}