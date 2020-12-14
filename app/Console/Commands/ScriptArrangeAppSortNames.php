<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Traits\Handler;

class ScriptArrangeAppSortNames extends Command
{

    use Handler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'script:arrange_app_sort_names {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '整理应用广告类型名 {user: 设置执行用户}';

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
        $command_user = $this->argument( 'user' );
        /* 设置执行用户 */
        if( $command_user ) {
            static::setUser( $command_user );
        }
        /* 设置执行用户 */
        
        //
        static::$Logger->info( "test" );
    }
}
