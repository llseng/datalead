<?php
namespace App\Traits;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * 实时脚本Trait
 */
trait Handler
{
    static public $Logger;
    static public $Level;

    /**
     * 日志目录
     *
     * @return string
     */
    static public function getLogDir() {
        return \storage_path('logs');
    }

    /**
     * 日志文件
     * 
     * @return string
     */
    static public function loggerFile( ) {
        return static::getLogDir(). DIRECTORY_SEPARATOR. static::$Logger->getName(). '_'. date( "Ymd" ). ".log";
    }

    /**
     * 日志加载/重载
     * 
     * @return void
     */
    static public function loggerLoad( ) {
        $logger_file = static::loggerFile( );
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
    
    /**
     * 日志初始化
     *
     * @return void
     */
    static public function loggerInit()
    {
        if( isset( static::$Logger ) ) return ;

        $basename = basename( static::class );
        
        static::$Logger = new Logger( $basename );
        !isset( static::$Level ) && static::$Level = Logger::DEBUG;
        static::loggerLoad( );
        
        return ;
    }

    /**
     * 设置日志等级
     *
     * @param int $level 默认 Logger::INFO
     * @return void
     */
    static public function setLoggetLevel( $level = null ) {
        \is_null( $level ) && $level = Logger::INFO;

        static::$Level = $level;
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
