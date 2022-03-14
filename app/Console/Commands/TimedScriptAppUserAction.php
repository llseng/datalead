<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Traits\AppHandler;

use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppCallback as AppCallbackL;
use App\Logic\AppUserAction as AppUserActionL;

use App\Logic\AppData\Click\ByteData as ClickByteData;
use App\Logic\AppData\Click\KuaiShouData as ClickKuaiShouData;
use App\Logic\AppData\Click\TxadData as ClickTxadData;

use App\Logic\AppData\Click\Callback\Callback as ClickCallback;
use App\Logic\AppData\Click\Callback\ByteStrategy;
use App\Logic\AppData\Click\Callback\KuaiShouStrategy;
use App\Logic\AppData\Click\Callback\TxadStrategy;

class TimedScriptAppUserAction extends Command
{

    use AppHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timed_script:app_user_action {model} {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '应用用户绑定行为事件 {model: start restart stop status} {user: 设置执行用户}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function app_handle( $app_id )
    {
        static::setTitle( "php datalead app_user_action: ". $app_id );
        DB::reconnect(); //重新连接数据库 子进程会继承父进程数据库连接 导致报错
        // DB::enableQueryLog(); //开启SQL日志
        $AppUsersL = new AppUsersL( $app_id );
        $AppUserActionL = new AppUserActionL( $app_id );

        $ClickCallback = new ClickCallback( $app_id );
        $ClickCallbackStrategys = [
            ClickByteData::PLATFORM_ID => new ByteStrategy(),
            ClickKuaiShouData::PLATFORM_ID => new KuaiShouStrategy(),
            ClickTxadData::PLATFORM_ID => new TxadStrategy(),
        ];

        $action_last_id = 0;

        $sleep_s = 1;
        $sleep_max_s = $sleep_s << static::$sleep_max_bit;
        $action_limit = 10000; //记录限制

        START: {
            static::$Logger->debug( $app_id. ">START" );
            static::$Logger->debug( $app_id. ">action_last_id ". $action_last_id );
        }
        //两天内注册用户
        $userSubQuery = DB::table( $AppUsersL->getTable() )
        ->select( [
            'unique_id', 
            'init_id', 
            'channel', 
            'callback_url'
        ] )
        ->where( 'create_date', ">=", date("Y-m-d", \strtotime("-2 day") ) );

        $app_action_m = DB::table( $AppUserActionL->getTable(). " as actions" )
        ->select( [
            "actions.id", 
            "actions.init_id", 
            "actions.type", 
            "actions.content", 
            "users.unique_id", 
            "users.channel", 
            "users.callback_url"
        ] )
        ->join( DB::raw( "(". $userSubQuery->toSql(). ") as users"), "actions.init_id", "=", "users.init_id" )
        ->mergeBindings( $userSubQuery );
        if( $action_last_id ) {
            $app_actions = $app_action_m->where( "actions.id", '>', $action_last_id )
            // ->whereNotNull("users.unique_id")
            ->limit( $action_limit )
            ->get()
            ->toArray();
        }else{
            $app_actions = $app_action_m
            // ->whereNotNull("users.unique_id")
            ->orderBy('actions.id', 'desc')
            ->limit( 1 )
            ->get()
            ->toArray();
        }

        if( empty( $app_actions ) ) {
            static::$Logger->warn( $app_id. ">app_actions empty" );
            goto AGAIN; //没有数据 进入随眠
        }
        static::$Logger->debug( $app_id. ">app_actions", $app_actions );

        static::$Logger->info( $app_id. ">app_actions", [$app_actions[0]['id'], $app_actions[ \count( $app_actions ) - 1 ]['id']] );

        $sleep_s = 1; //有数据 随眠时间重置为1
        
        $action_last_id = $app_actions[ \count( $app_actions ) - 1 ]['id'];
        
        foreach ($app_actions as $action_data) {
            if( empty( $action_data['unique_id'] ) ) {
                static::$Logger->error( $app_id. ">app_users ". $action_data['init_id']. " channel ". $action_data['channel']. " unique_id empty" );
                continue;
            }

            if( !isset( $ClickCallbackStrategys[ $action_data['channel'] ] ) ) {
                static::$Logger->error( $app_id. ">app_action ". $action_data['unique_id']. " channel ". $action_data['channel']. " strategy empty" );
                continue;
            }

            $ClickCallback->setStrategy( $ClickCallbackStrategys[ $action_data['channel'] ] );
            $ClickCallback->setData( $action_data );
            $query = null;

            switch ($action_data['type']) {
                case 'cruxAction': //关键行为
                    $query = $ClickCallback->cruxAction(); //激活事件回调数据
                    if( empty( $query ) ) {
                        static::$Logger->error( $app_id. ">app_action cruxAction ". $action_data['unique_id']. " query empty" );
                    }
                    break;
            }

            if( empty( $query ) ) {
                static::$Logger->debug( $app_id. ">app_action ". $action_data['unique_id']. " continue" );
                continue;
            }

        }

        CLEAN: { //清理
            unset( $app_actions, $action_data );

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
