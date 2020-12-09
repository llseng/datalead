<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use App\Traits\Handler;
use App\GameAppCallback as GACM;
use App\Logic\AppCallback;

class AppCallbackHandler extends Command
{
    use Handler;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rtime_script:app_callback_handler {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '应用回调实时脚本 {user: 设置执行用户}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // static::setLoggetLevel(); //日志等级 INFO
        static::loggerInit();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $command_user = $this->argument( 'user' );
        /* 设置执行用户 */
        if( $command_user ) {
            static::setUser( $command_user );
        }
        /* 设置执行用户 */

        $sleep_s = 1;
        $sleep_max_s = $sleep_s << 3;
        do{
            $callback_list = GACM::where( 'status', 0 )->limit(100)->get()->toArray();
            
            if( $callback_list ) {
                static::$Logger->info("callback_list", [$callback_list[0]['id'], $callback_list[ \count( $callback_list ) - 1 ]['id']] );
        
                $sleep_s = 1;

                foreach ($callback_list as $key => $val) {
                    $url = $val['url'];
                    
                    if( $val['query'] ) {
                        $url .= \strpos( $url, '?' )? '&': '?';
                        $url .= $val['query'];
                    }

                    $result = @\file_http_request( $url, ['timeout' => 1] );
                    if( $result === false ) {
                        $result = 'request_fail';
                        static::$Logger->error( $val['id']. " req fail" );
                    }
                    
                    $update_status = AppCallback::update( $val['id'], $result );
                    if( !$update_status ) {
                        static::$Logger->error( $val['id']. " update fail" );
                    }
                }

                continue;
            }

            static::$Logger->debug( "sleep $sleep_s" );
            sleep( $sleep_s );
            $sleep_s < $sleep_max_s && $sleep_s <<= 1;
            static::loggerLoad();
        }while( $sleep_s <= $sleep_max_s );

    }
}
