<?php
namespace App\Traits;

use Monolog\Logger;
use Workerman\Worker;
use Workerman\Lib\Timer;
use Monolog\Handler\StreamHandler;

/**
 * 实时脚本Trait
 */
trait Handler
{
    static public $Logger;
    static public $Level;

    static public function getLogDir() {
        return \storage_path('logs');
    }

    static public function loggerFile( ) {
        return static::getLogDir(). DIRECTORY_SEPARATOR. static::$Logger->getName(). '_'. date( "Ymd" ). ".log";
    }

    static public function loggerLoad( ) {
        $logger_file = static::loggerFile( static::$Logger );
        $logget_handlers = static::$Logger->getHandlers();
        if( $logget_handlers ) {
            if( static::$Logger->getHandlers()[0]->getUrl() !== $logger_file ) {
                static::$Logger->close();
                $StreamHandler = new StreamHandler( $logger_file, static::$Level );
                static::$Logger->setHandlers( [ $StreamHandler ] );
            }
        }else{
            $StreamHandler = new StreamHandler( $logger_file, static::$Level );
            static::$Logger->setHandlers( [ $StreamHandler ] );
        }

        return ;
    }
    
    static public function loggerInit()
    {
        if( isset( static::$Logger ) ) return ;

        $path_parts = pathinfo( static::class );
        $basename = $path_parts['filename'];
        
        static::$Logger = new Logger( $basename );
        static::$Level = Logger::DEBUG;
        static::loggerLoad( );
        
        return ;
    }

}
