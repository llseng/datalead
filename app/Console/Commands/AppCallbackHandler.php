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
    protected $signature = 'rtime_script:app_callback_handler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '应用回调实时脚本';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        static::loggerInit();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sleep_s = 1;
        $sleep_max_s = $sleep_s << 11;
        do{
            $callback_list = GACM::where( 'status', 0 )->limit(100)->get()->toArray();
            
            if( $callback_list ) {
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

            static::$Logger->info( "sleep $sleep_s" );
            sleep( $sleep_s );
            $sleep_s < $sleep_max_s && $sleep_s <<= 1;
        }while( $sleep_s <= $sleep_max_s );

    }
}
