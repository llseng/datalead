<?php
namespace App\Traits;

use Monolog\Logger;
use App\GameApp as GAM;

/**
 * 应用处理模板
 */
trait AppHandler
{
    
    use Handler, ProcTool {
        ProcTool::setUser insteadof Handler; //使用ProcTool的setUser方法
    }

    static public $error_max_num = 10;

    static public $error_num = 0;

    static public $sleep_max_bit = 4;

    /**
     * 子进程列表
     *
     * @var array
     */
    static public $apid_list = [];
    
    public function __construct()
    {
        parent::__construct();
        static::loggerInit();
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
                static::$error_num++;
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
                    if( !static::kill( $val ) ) {
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
        static::verify();

        $pid_file = basename( static::class ). ".pid";
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
                    if( static::kill( $pid, SIGINT ) ) {
                        $this->info( "stop success" );
                    }
                    \sleep( 1 );
                }
                break;
                
            case 'stop':
                if( static::kill( $pid, SIGINT ) ) {
                    $this->info( "stop success" );
                    @\file_put_contents( $pid_file, '' );
                }
                exit;
                break;
            
            default:
                exit;
                break;
        }

        static::daemon();

        /* 设置执行用户 */
        if( $command_user ) {
            static::setUser( $command_user ) ;
        }
        /* 设置执行用户 */

        $pid = \posix_getpid( );
        @\file_put_contents( $pid_file, $pid ); //当前进程id写入到id文件
        
        $sleep_s = 1;
        $sleep_max_s = $sleep_s << static::$sleep_max_bit;

        \pcntl_signal( SIGCHLD, [static::class, "sig_handler"] ); //子进程退出信号
        \pcntl_signal( SIGTERM, [static::class, "sig_handler"] ); //kill 默认信号
        \pcntl_signal( SIGINT, [static::class, "sig_handler"] ); //CTRL + C 退出信号

        HANDLE_START: {
            static::$Logger->info( "START", static::$apid_list );
            pcntl_signal_dispatch(); //
        }

        static::$Logger->debug( "error_num ". static::$error_num );
        if( static::$error_max_num <= static::$error_num ) {
            static::$Logger->error( "process run error num > ". static::$error_max_num );
            static::kill( $pid, SIGINT );
        }

        $GAlist = GAM::pluck( "name", "id" )->toArray();

        static::$Logger->debug( "GAlist", $GAlist );

        static::$Logger->debug( "apid_list check" );
        $diff_apids = \array_diff_key( static::$apid_list, $GAlist );
        static::$Logger->debug( "diff_apids", $diff_apids );
        
        if( $diff_apids ) { //杀死多余应用进程
            $sleep_s = 1;

            foreach ($diff_apids as $key => $val) {
                static::$Logger->info( $key. "kill" );

                if( !static::kill( static::$apid_list[ $key ] ) ) {
                    static::$Logger->error( $key. " kill error: ". \posix_strerror( \posix_errno() ) );
                    continue;
                }

                static::$Logger->info( $key. "kill succ" );
                unset( static::$apid_list[ $key ] );
            }
        }

        static::$Logger->debug( "GAlist check" );
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
                        
                        static::$Logger->info( $key. " user bind end" );
                        $pid = \posix_getpid();
                        static::$Logger->info( $key. " pid ". $pid );
                        static::kill( $pid );
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
            static::$Logger->info( "END" );
        }
        exit;
    }

}
