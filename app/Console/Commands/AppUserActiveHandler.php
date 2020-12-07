<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use Monolog\Logger;
use App\Traits\Handler;
use App\GameApp as GAM;
use App\Logic\AppUsers as AppUsersL;
use App\Logic\AppCallback as AppCallbackL;
use App\Logic\AppInitData as AppInitDataL;
use App\Logic\AppUsersFormat as AppUsersFormatL;
use App\Logic\AppByteClickData as AppByteClickDataL;

class AppUserActiveHandler extends Command
{
    use Handler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rtime_script:app_user_active_handler {model} {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '应用用户活跃转化事件 {model: start restart stop status} {user: 设置执行用户}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        static::setLoggetLevel( /*Logger::DEBUG*/ ); //日志等级 INFO
        static::loggerInit();
    }

    /**
     * 子进程列表
     *
     * @var array
     */
    static public $apid_list;

    /**
     * 检测子进程是否正在运行
     *
     * @param int $pid
     * @return boolean
     */
    static public function isRunning( $pid ) {
        if( !extension_loaded( 'pcntl' ) || !extension_loaded( 'posix' ) ) {
            static::$Logger->error('You must install PCNTL POSIX extension!');
            return false;
        }

        if( !\posix_kill( \intval( $pid ), 0 ) ) {
            static::$Logger->error( $pid. " kill 0 error: ". \posix_strerror( \posix_errno() ) );
            return false;
        }

        return true;
    }

    /**
     * 杀死子进程
     *
     * @param int $pid
     * @param int $sig
     * @return void
     */
    static public function KillProcess( $pid, $sig = null ) {
        if( !extension_loaded( 'pcntl' ) || !extension_loaded( 'posix' ) ) {
            static::$Logger->error('You must install PCNTL POSIX extension!');
            return false;
        }

        \is_null( $sig ) && $sig = SIGKILL;
        if( !\posix_kill( \intval( $pid ), $sig ) ) {
        // if( !\posix_kill( \intval( $pid ), SIGINT ) ) {
            static::$Logger->error( $pid. " kill error: ". \posix_strerror( \posix_errno() ) );
            return false;
        }

        return true;
    }

    /**
     * 信号处理函数
     *
     * @param int $signo
     * @return void
     */
    static public function sig_handler( $signo ) {
        switch ( $signo ) {
            case SIGCHLD: //子进程退出
                static::$Logger->warn( "child process exit sig" );
                $s_status;
                $s_pid = \pcntl_waitpid( -1, $s_status, WNOHANG );
                if( $s_pid ) {
                    static::$Logger->warn( $s_pid. " child process exit" );
                    $p_list = \array_flip( static::$apid_list );
                    if( isset( $p_list[ $s_pid ] ) ) {
                        static::$Logger->debug( $p_list[ $s_pid ]. " unset" );
                        unset( static::$apid_list[ $p_list[ $s_pid ] ] );
                    }
                }

            break;

            case SIGTERM: // kill 默认信号
            case SIGINT: // CTRL + C 退出信号
                static::$Logger->warn( "process exit sig" );
                foreach ( static::$apid_list as $key => $val) {
                    if( !static::KillProcess( $val ) ) {
                        continue;
                    }

                    static::$Logger->debug( $key. " kill succ" );
                }

                static::$Logger->info( "handle end" );
                exit;
            break;
            
            default:
            
            break;
        }
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if( !extension_loaded( 'pcntl' ) || !extension_loaded( 'posix' ) ) {
            $this->error('You must install PCNTL POSIX extension!');
            static::$Logger->error('You must install PCNTL POSIX extension!');
            exit();
        }

        $pid_file = "app_user_active_handler.pid";
        $pid = (int)@\file_get_contents( $pid_file );
        $p_status = false;
        if( $pid ) {
            $p_run_status = static::isRunning( $pid );
        }

        $command_model = $this->argument( 'model' );
        $command_user = $this->argument( 'user' );
        $this->info( "pid $pid , command_model: $command_model" );
        switch ( $command_model ) {
            case 'start':
            case 'restart':
                if( $pid ) { //应用正在运行, 杀死后启动
                    if( static::KillProcess( $pid, SIGINT ) ) {
                        $this->info( "stop success" );
                    }
                    \sleep( 1 );
                }
                break;
                
            case 'stop':
                if( static::KillProcess( $pid, SIGINT ) ) {
                    $this->info( "stop success" );
                    @\file_put_contents( $pid_file, '' );
                }
                exit;
                break;
            
            default:
                exit;
                break;
        }

        /* 守护进程模式 */
        $pid = \pcntl_fork();
        if (-1 === $pid) {
            throw new Exception('Fork fail');
        } elseif ($pid > 0) {
            $this->info( "start success" ); //提示
            exit(0);
        }
        if (-1 === \posix_setsid()) {
            throw new Exception("Setsid fail");
        }
        // Fork again avoid SVR4 system regain the control of terminal.
        $pid = \pcntl_fork();
        if (-1 === $pid) {
            throw new Exception("Fork fail");
        } elseif (0 !== $pid) {
            exit(0);
        }
        /* 守护进程模式 */

        /* 设置执行用户 */
        if( $command_user ) {
            static::setUser( $command_user ) ;
        }
        /* 设置执行用户 */

        $pid = \posix_getpid( );
        @\file_put_contents( $pid_file, $pid ); //当前进程id写入到id文件

        static::$apid_list = [];
        $sleep_s = 1;
        $sleep_max_s = $sleep_s << 4;

        \pcntl_signal( SIGCHLD, [static::class, "sig_handler"] ); //子进程退出信号
        \pcntl_signal( SIGTERM, [static::class, "sig_handler"] ); //kill 默认信号
        \pcntl_signal( SIGINT, [static::class, "sig_handler"] ); //CTRL + C 退出信号

        HANDLE_START: {
            static::$Logger->info( "handle start ===", static::$apid_list );
            pcntl_signal_dispatch(); //
        }

        $GAlist = GAM::pluck( "name", "id" )->toArray();

        static::$Logger->debug( "GAlist", $GAlist );

        static::$Logger->debug( "apid_list check ---" );
        $diff_apids = \array_diff_key( static::$apid_list, $GAlist );
        static::$Logger->debug( "diff_apids", $diff_apids );
        
        if( $diff_apids ) { //杀死多余应用进程
            $sleep_s = 1;

            foreach ($diff_apids as $key => $val) {
                static::$Logger->info( $key. "kill" );

                if( !static::KillProcess( static::$apid_list[ $key ] ) ) {
                    static::$Logger->error( $key. " kill error: ". \posix_strerror( \posix_errno() ) );
                    continue;
                }

                static::$Logger->info( $key. "kill succ" );
                unset( static::$apid_list[ $key ] );
            }
        }

        static::$Logger->debug( "GAlist check ---" );
        $diff_GAlist = \array_diff_key( $GAlist, static::$apid_list );
        static::$Logger->debug( "diff_GAlist", $diff_GAlist );

        if( $diff_GAlist ) { //创建应用进程
            $sleep_s = 1;

            foreach ($diff_GAlist as $key =>  $val) {
                $spid = \pcntl_fork();
                switch ( $spid ) {
                    case -1:
                        static::$Logger->error( $key. " fork error: ". \pcntl_strerror( \pcntl_errno() ) );
                        break;

                    case 0:
                        static::$apid_list = [];
                        try {
                            static::app_handle( $key );
                        } catch (\Throwable $th) {
                            static::$Logger->error( "$key process run error",[$th->getCode(), $th->getFile(), $th->getLine(), $th->getMessage()] );
                        }
                        
                        static::$Logger->info( $key. " end" );
                        $pid = \posix_getpid();
                        static::$Logger->info( $key. " pid ". $pid );        
                        static::KillProcess( $pid );
                        exit;
                        break;
                    
                    default:
                        static::$Logger->info( $key. " fork succ" );
                        static::$apid_list[ $key ] = $spid;
                        break;
                }
            }

        }

        static::$Logger->debug( "process check" );
        foreach (static::$apid_list as $key => $val) {
            if( !static::isRunning( $val ) ) {

                static::$Logger->warn( $key. " process not running" );
                unset( static::$apid_list[ $key ] );
            }
        }
        
        static::$Logger->debug( "sleep $sleep_s" );
        sleep( $sleep_s );

        $sleep_s < $sleep_max_s && $sleep_s <<= 1;
        static::loggerLoad();

        goto HANDLE_START;

        HANDLE_END: {
            static::$Logger->info( "handle end" );
        }
        exit;
    }

    static public function app_handle( $app_id ) {
        
        DB::reconnect(); //重新连接数据库 子进程会继承父进程数据库连接 导致报错
        DB::enableQueryLog(); //开启SQL日志
        $AppUsersL = new AppUsersL( $app_id );
        $AppInitDataL = new AppInitDataL( $app_id );
        $AppByteClickDataL = new AppByteClickDataL( $app_id );

        $init_last_id = 0;

        $sleep_s = 1;
        $sleep_max_s = $sleep_s << 4;
        $init_limit = 100; //记录限制
        $data_limit = $init_limit * 50; //数据限制
        $time_limit = 10 * 60; //时间限制 十分钟

        APP_START: {
            static::$Logger->debug( $app_id. ">START" );
            static::$Logger->debug( $app_id. ">init_last_id ". $init_last_id );
        }
        
        $app_inits_m = DB::table( $AppInitDataL->getTable(). " as inits" )->select( "inits.id", "inits.init_id", "inits.create_date", "users.unique_id", "users.create_date as reg_date" )->join( $AppUsersL->getTable(). " as users", "inits.init_id", "=", "users.init_id" );
        if( $init_last_id ) {
            $app_inits = $app_inits_m/*->where("inits.create_date", "=", date("Y-m-d"))*/->where( "inits.id", '>', $init_last_id )->whereNotNull("users.unique_id")->limit( $init_limit )->get()->toArray();
        }else{
            $app_inits = $app_inits_m/*->where("inits.create_date", "=", date("Y-m-d"))*/->whereNotNull("users.unique_id")->orderBy('inits.id', 'desc')->limit( 1 )->get()->toArray();
        }

        if( empty( $app_inits ) ) {
            static::$Logger->warn( $app_id. ">app_inits empty" );
            goto APP_AGAIN; //没有数据 进入随眠
        }
        static::$Logger->info( $app_id. ">app_inits". \var_export($app_inits, true));

        static::$Logger->info( $app_id. ">app_inits", [$app_inits[0]->id, $app_inits[ \count( $app_inits ) - 1 ]->id] );

        $sleep_s = 1; //有数据 随眠时间重置为1
        
        $last_app_init = $app_inits[ \count( $app_inits ) - 1 ];

        $init_last_id = $last_app_init->id;

        $Keep2_uids = []; //次留用户点击ID
        foreach ($app_inits as $init_data) {
            $ago_date = date("Y-m-d", \strtotime($init_data->create_date. "-1 day"));
            if( $init_data->reg_date == $ago_date ) {
                $Keep2_uids[] = $init_data->unique_id;
            }
        }
        
        static::$Logger->debug( $app_id. ">Keep2_uids", $Keep2_uids );
        
        $click_ids = [];
        $Keep2_uids && $click_ids = DB::table( $AppByteClickDataL->getTable() )->select( DB::raw("MIN( id ) mid") )->whereIn("unique_id", $Keep2_uids)->groupBy("unique_id")->pluck("mid")->toArray();

        static::$Logger->debug( $app_id. ">click_ids", $click_ids );
        
        if( $click_ids ) {
            $click_datas = DB::table( $AppByteClickDataL->getTable() )->select( "callback_url" )->whereIn("id", $click_ids)->pluck("callback_url")->toArray();

            foreach ($click_datas as $click_data) {
                \preg_match( "/^http[s]?:\/\/\w+(\.\w+)+.+/", $click_data ) && AppCallbackL::create( $app_id, $click_data, ['event_type' => 6] );
                // \preg_match( "/^http[s]?:\/\/\w+(\.\w+)+.+/", $click_data ) && static::$Logger->info( $app_id. ">callback_url: ". $click_data );
            }
        }
        
        //清理
        unset( $app_inits, $Keep2_uids, $click_ids, $click_datas );

        goto APP_START; //重新开始

        APP_AGAIN: {
            static::$Logger->debug( $app_id. ">sleep $sleep_s" );
            sleep( $sleep_s );
    
            $sleep_s < $sleep_max_s && $sleep_s <<= 1;
            static::loggerLoad();

            static::$Logger->debug( $app_id. ">AGAIN" );
            goto APP_START; //随眠完成 重新开始
        };

        APP_END: {
            static::$Logger->info( $app_id. ">END" );
        };

    }

}
