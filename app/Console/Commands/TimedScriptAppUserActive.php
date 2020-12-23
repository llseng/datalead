<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Traits\AppHandler;

use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppCallback as AppCallbackL;
use App\Logic\AppInitData as AppInitDataL;

use App\Logic\AppData\Click\ByteData as ClickByteData;
use App\Logic\AppData\Click\KuaiShouData as ClickKuaiShouData;
use App\Logic\AppData\Click\TxadData as ClickTxadData;

use App\Logic\AppData\Click\Callback\Callback as ClickCallback;
use App\Logic\AppData\Click\Callback\ByteStrategy;
use App\Logic\AppData\Click\Callback\KuaiShouStrategy;
use App\Logic\AppData\Click\Callback\TxadStrategy;

class TimedScriptAppUserActive extends Command
{

    use AppHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timed_script:app_user_active {model} {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '应用启动用户绑定活跃事件 {model: start restart stop status} {user: 设置执行用户}';
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function app_handle( $app_id )
    {
        
        DB::reconnect(); //重新连接数据库 子进程会继承父进程数据库连接 导致报错
        // DB::enableQueryLog(); //开启SQL日志
        $AppUsersL = new AppUsersL( $app_id );
        $AppInitDataL = new AppInitDataL( $app_id );

        $ClickCallback = new ClickCallback( $app_id );
        $ClickCallbackStrategys = [
            ClickByteData::PLATFORM_ID => new ByteStrategy(),
            ClickKuaiShouData::PLATFORM_ID => new KuaiShouStrategy(),
            ClickTxadData::PLATFORM_ID => new TxadStrategy(),
        ];

        $init_last_id = 0;

        $sleep_s = 1 << 6;
        $sleep_max_s = $sleep_s << 12;
        $init_limit = 10000; //记录限制

        START: {
            static::$Logger->debug( $app_id. ">START" );
            static::$Logger->debug( $app_id. ">init_last_id ". $init_last_id );
        }
        //七天内注册用户
        $userSubQuery = DB::table( $AppUsersL->getTable() )
        ->select( [
            'unique_id', 
            'init_id', 
            'channel', 
            'create_date', 
            'click_id', 
            'callback_url'
        ] )
        ->where( 'create_date', ">=", date("Y-m-d", \strtotime("-7 day") ) );

        $app_inits_m = DB::table( $AppInitDataL->getTable(). " as inits" )
        ->select( [
            "inits.id", 
            "inits.init_id", 
            "inits.create_date", 
            "users.unique_id", 
            "users.channel", 
            "users.create_date as reg_date", 
            "users.click_id", 
            "users.callback_url"
        ] )
        ->join( DB::raw( "(". $userSubQuery->toSql(). ") as users"), "inits.init_id", "=", "users.init_id" )
        ->mergeBindings( $userSubQuery );
        if( $init_last_id ) {
            $app_inits = $app_inits_m->where( "inits.id", '>', $init_last_id )
            ->whereNotNull("users.unique_id")
            ->limit( $init_limit )
            ->get()
            ->toArray();
        }else{
            $app_inits = $app_inits_m->whereNotNull("users.unique_id")
            ->orderBy('inits.id', 'desc')
            ->limit( 1 )
            ->get()
            ->toArray();
        }

        if( empty( $app_inits ) ) {
            static::$Logger->warn( $app_id. ">app_inits empty" );
            goto AGAIN; //没有数据 进入随眠
        }
        static::$Logger->info( $app_id. ">app_inits", $app_inits );

        static::$Logger->info( $app_id. ">app_inits", [$app_inits[0]['id'], $app_inits[ \count( $app_inits ) - 1 ]['id']] );

        $sleep_s = 1 << 6; //有数据 随眠时间重置为64
        
        $last_app_init = $app_inits[ \count( $app_inits ) - 1 ];

        $init_last_id = $last_app_init['id'];
        
        foreach ($app_inits as $init_data) {
            $reg_date = \date_create( $init_data['reg_date'] );
            $create_date = \date_create( $init_data['create_date'] );
            $diffDate = \date_diff( $reg_date, $create_date );
            
            if( !isset( $ClickCallbackStrategys[ $init_data['channel'] ] ) ) {
                static::$Logger->error( $app_id. ">app_users ". $init_data['unique_id']. " channel ". $init_data['channel']. " strategy empty" );
                continue;
            }

            $ClickCallback->setStrategy( $ClickCallbackStrategys[ $init_data['channel'] ] );

            switch ($diffDate->days) {
                case 1: //次留

                    $query = $ClickCallback->keep2(); //激活事件回调数据
                    if( empty( $query ) ) {
                        static::$Logger->error( $app_id. ">app_users keep2 ". $init_data['unique_id']. " query empty" );
                    }

                    break;
            }

            if( empty( $query ) ) {
                static::$Logger->debug( $app_id. ">app_users ". $init_data['unique_id']. " continue" );
                continue;
            }

            \preg_match( "/^http[s]?:\/\/\w+(\.\w+)+.+/", $init_data['callback_url'] ) && AppCallbackL::create( $app_id, $init_data['callback_url'], $query );

        }

        CLEAN: { //清理
            unset( $app_inits, $init_data );

            goto START; //重新开始
        }

        AGAIN: {
            static::$Logger->debug( "sleep $sleep_s" );
            sleep( $sleep_s );
    
            $sleep_s < $sleep_max_s && $sleep_s <<= 1;
            static::loggerLoad();

            goto START; //随眠完成 重新开始
        }

        static::$Logger->info( $app_id. ">END" );
        exit;

    }
}
