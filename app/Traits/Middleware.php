<?php
namespace App\Traits;

/**
 * 中间件
 */
trait Middleware
{
    /**
     * 处理程度是否符合规定
     *
     * @param callable $handle
     * @return boolean
     */
    static public function isHandle( callable $handle ) {
        $ReflectionFunction = new ReflectionFunction( $handle );
        $Parameters = $ReflectionFunction->getParameters();
        //必须是2个参数
        if( \count( $Parameters ) != 2 ) {
            return false;
        }
        //参数1不可设置类型
        if( $Parameters[0]->hasType() ) {
            return false;
        }
        //参数2必须为可执行结构
        if( !$Parameters[1]->isCallable() ) {
            return false;
        }

        return true;
    }

    /**
     * 处理程序列表
     *
     * @var array
     */
    protected $handles = [];

    public function __construct() {

    }

    /**
     * 添加处理程序
     *
     * @param callable $handle
     * @return void
     */
    public function pushHandle( callable $handle ) {
        if( !static::isHandle( $handle ) ) {
            return false;
        }

        return \array_push( $this->handles, $handle );
    }

    /**
     * 设置处理程序
     *
     * @param array $handles
     * @return int
     */
    public function setHandles( array $handles ) {
        $push_num = 0;
        foreach ($handles as $handle) {
            if( !\is_callable( $handle ) ) continue;
            if( $this->pushHandle( $handle ) ) {
                $push_num++;
            }
        }
        return $push_num;
    }

    public function getHandles( ) {
        return $this->handles;
    }

    /**
     * 打包
     */
    protected function packHandle( ) {
        $app = function ($params ) { 
            return $params;
        };
        $handles = $this->getHandles();

        foreach ($handles as $key => $handle) {
            $app = function ( $params )use( $app, $handle) {
                return $handle( $app );
            };
        }

        return $app;
    }

    /**
     * 处理
     *
     * @param all $params
     * @return all
     */
    public function handle( $params ) {
        $app = $this->packHandle();
        return $app( $params );
    }

}
