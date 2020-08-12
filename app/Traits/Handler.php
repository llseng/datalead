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

    /**
     * 设执行用户
     *
     * @param string $user
     * @param string $group
     * @return bool
     */
    static public function setUser( $user, $group = null ) {

        if( !extension_loaded( 'posix' ) ) {
            static::$Logger->error('You need install POSIX extension!');
            return false;
        }
        
        $user_info = \posix_getpwnam( $user );
        if( empty( $user_info ) ) {
            static::$Logger->warn( "User $user not exists" );
            return false;
        }
        $uid = $user_info['uid'];
        $gid = $user_info['gid'];

        static::$Logger->warn( "User $user", $user_info );

        // Set uid and gid.
        if ($uid !== \posix_getuid() || $gid !== \posix_getgid()) {
            if (!\posix_setgid($gid) || !\posix_initgroups($user_info['name'], $gid) || !\posix_setuid($uid)) {
                static::$Logger->warn( "Change user $user fail" );
                return false;
            }
        }

        return true;
    }

}
