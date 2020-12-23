<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Traits\AppHandler;

use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppCallback as AppCallbackL;
use App\Logic\AppInitData as AppInitDataL;
use App\Logic\AppClickData as AppClickDataL;


use App\Logic\AppData\Click\ByteData as ClickByteData;
use App\Logic\AppData\Click\KuaiShouData as ClickKuaiShouData;
use App\Logic\AppData\Click\TxadData as ClickTxadData;

use App\Logic\AppData\Click\Callback\Callback as ClickCallback;
use App\Logic\AppData\Click\Callback\ByteStrategy;
use App\Logic\AppData\Click\Callback\KuaiShouStrategy;
use App\Logic\AppData\Click\Callback\TxadStrategy;

class TimedScriptAppUserBind extends Command
{

    use AppHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timed_script:app_user_bind {model} {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '应用用户绑定点击数据 {model: start restart stop status} {user: 设置执行用户}';

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
        $AppClickDataL = new AppClickDataL( $app_id );

        $ClickCallback = new ClickCallback( $app_id );
        $ClickCallbackStrategys = [
            ClickByteData::PLATFORM_ID => new ByteStrategy(),
            ClickKuaiShouData::PLATFORM_ID => new KuaiShouStrategy(),
            ClickTxadData::PLATFORM_ID => new TxadStrategy(),
        ];
        
        $AppUsersM = $AppUsersL->getTableModelObj();
        $AppInitDataM = $AppInitDataL->getTableModelObj();
        $AppClickDataM = $AppClickDataL->getTableModelObj();
        
        $sleep_s = 1;
        $sleep_max_s = $sleep_s << static::$sleep_max_bit;
        $user_limit = 100; //用户限制
        $data_limit = $user_limit * 100; //数据限制
        $time_limit = 60 * 60 * 10; //时间限制 10小时
        
        START: {
            static::$Logger->info( $app_id. ">START" );
        }
        
        $app_users = $AppUsersM->where( "channel", 0 )
        ->limit( $user_limit )
        ->get()
        ->toArray();
        if( empty( $app_users ) ) {
            static::$Logger->warn( $app_id. ">app_users empty" );
            goto AGAIN; //随眠
        }

        $sleep_s = 1; //有数据 随眠时间重置为1

        $first_app_user = $app_users[ 0 ];
        $last_app_user = $app_users[ \count( $app_users ) - 1 ];

        static::$Logger->info( $app_id. ">app_users", [$first_app_user['id'], $last_app_user['id']] );
        
        $first_time = \strtotime( $first_app_user['create_date']. " ". $first_app_user['create_time'] ) - $time_limit;
        $last_time = \strtotime( $last_app_user['create_date']. " ". $last_app_user['create_time'] );
        //点击数据
        $click_datas = $AppClickDataM->select( [
            "id", 
            "unique_id", 
            "platform_id", 
            "account_id", 
            "gid", 
            "aid", 
            "cid", 
            "imei", 
            "idfa", 
            "androidid", 
            "oaid", 
            "mac", 
            "ip", 
            "os", 
            "ts", 
            "ua", 
            "callback_url"
        ] )
        ->whereBetween( "ts", [$first_time * 1000, $last_time * 1000] )
        ->orderBy('id', 'desc')
        ->limit( $data_limit )
        ->get()
        ->toArray();

        if( empty( $click_datas ) ) {
            //没有字节点击数据 用户全部设置为自然人
            static::$Logger->warn( $app_id. ">click_datas empty" );

            $user_ids = \array_column( $app_users, "id" );
            $update_status = $AppUsersM->whereIn( "id", $user_ids )
            ->update( [ "channel"=>100 ] );
            if( empty( $update_status ) ) {
                static::$Logger->error( $app_id. ">app_users update error", $user_ids );
            }

            unset( $user_ids );

            goto CLEAN;
        }

        static::$Logger->info( $app_id. ">click_datas", [$click_datas[0]['id'], $click_datas[ \count( $click_datas ) - 1 ]['id']] );

        foreach ($app_users as $user) {
            $init_data = $AppInitDataM->select([
                "imei", 
                "idfa", 
                "androidid", 
                "oaid", 
                "mac", 
                "ip", 
                "ua", 
                "os"
            ])
            ->where( 'init_id', $user['init_id'] )
            ->first();
            
            $match_status = false;
            $match_click_data = false;
            $update_data = [];
            $update_data['channel'] = 100;

            foreach ($click_datas as $click_data) {
                if( static::match_click( $init_data, $click_data ) ) {
                    $match_status = true;
                    $match_click_data = $click_data;
                    $update_data['channel'] = $click_data['platform_id'];
                    $update_data['unique_id'] = $click_data['unique_id'];
                    $update_data['account_id'] = $click_data['account_id'];
                    $update_data['gid'] = $click_data['gid'];
                    $update_data['aid'] = $click_data['aid'];
                    $update_data['cid'] = $click_data['cid'];
                    $update_data['click_id'] = $click_data['id'];
                    $update_data['callback_url'] = $click_data['callback_url'];
                    break;
                }
            }

            $update_status = $AppUsersM->where( "id", $user['id'] )->update( $update_data );
            if( empty( $update_status ) ) {
                static::$Logger->error( $app_id. ">app_users ". $user['id']. " update error" );
            }
            //匹配成功 创建通知回调
            if( $match_status ) {
                if( !isset( $ClickCallbackStrategys[ $match_click_data['platform_id'] ] ) ) {
                    static::$Logger->error( $app_id. ">app_users ". $user['id']. " platform_id ". $match_click_data['platform_id']. " strategy empty" );
                    continue;
                }

                $ClickCallback->setStrategy( $ClickCallbackStrategys[ $match_click_data['platform_id'] ] );
                $ClickCallback->setData( $match_click_data );

                $query = $ClickCallback->init(); //激活事件回调数据
                if( empty( $query ) ) {
                    static::$Logger->error( $app_id. ">app_users ". $user['id']. " query empty" );
                    continue;
                }

                AppCallbackL::create( $app_id, $match_click_data['callback_url'], $query );
            }
        }


        CLEAN: { //清理
            $ClickCallback->setData( [] );
            unset( $app_users, $click_data );

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

    static public function match_click( $init_data, $click_data ) {
        
        if( $init_data['os'] != $click_data['os'] ) return false;

        if( 
            $init_data['imei']
            && $click_data['imei']
            && \md5( $init_data['imei'] ) == $click_data['imei']
        ) {
            return true;
        }

        switch ( (int)$init_data['os'] ) {
            case 0: //安卓
                if( 
                    $init_data['androidid']
                    && $click_data['androidid']
                    && \md5( $init_data['androidid'] ) == $click_data['androidid']
                ) {
                    return true;
                }
        
                if( 
                    $init_data['oaid']
                    && $click_data['oaid']
                    && $init_data['oaid'] == $click_data['oaid']
                ) {
                    return true;
                }

                break;

            case 0: //IOS
                if( 
                    $init_data['idfa']
                    && $click_data['idfa']
                    && $init_data['idfa'] == $click_data['idfa']
                ) {
                    return true;
                }

                break;
        }

        if( 
            $init_data['mac']
            && $click_data['mac']
        ) {
            $init_data_mac = \implode( ":", str_split( $init_data['mac'], 2 ) );
            if( \md5( \strtoupper( $init_data_mac ) ) == $click_data['idfa'] ) return true;
        }

        if( 
            $init_data['ip']
            && $click_data['ip']
            && $init_data['ip'] == $click_data['ip']
            && $init_data['ua']
            && $click_data['ua']
        ) {
            $reg = "/^([^\(]+\([^\)]+\)).+/";
            $init_data_ua = \preg_replace( $reg, "$1", $init_data['ua'] );
            $click_data_ua = \preg_replace( $reg, "$1", $click_data['ua'] );

            $init_tmp_id = $init_data['ip']. \md5( $init_data_ua );
            $click_tmp_id = $click_data['ip']. \md5( $click_data_ua );
            if( $init_tmp_id == $click_tmp_id ) return true;
        }

        return false;

    }

}
