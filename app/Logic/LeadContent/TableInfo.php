<?php
namespace App\Logic\LeadContent;

/**
 * 输入框
 */
class TableInfo extends TableLine
{

    protected $handler;

    protected $filter;

    /**
     * 构造函数
     */
    public function __construct( string $title, string $name ) {
        parent::__construct( $title, $name );
        $this->setLineType( "info" );
    }

    /**
     * 设置处理程序
     *
     * @param callable $handler( array $list, TableInfo $obj )
     * @return void
     */
    public function setHandler( callable $handler ) {
        $this->handler = $handler;
    }

    public function getHandler( ) {
        if( !isset( $this->handler ) ) {
            $this->setHandler( function( array $list, TableInfo $obj ) {
                if( !isset( $list[ $obj->getName() ] ) ) {
                    return "";
                }

                return $list[ $obj->getName() ];
            } );
        }

        return $this->handler;
    }

    public function setFilter( callable $filter ) {
        $this->filter = $filter;
    }

    public function getFilter( ) {
        if( !isset( $this->filter ) ) {
            $this->setFilter( function( $value ) {
                return $value;
            } );
        }

        return $this->filter;
    }

    public function handle( array $list ) {
        $handler = $this->getHandler();
        $filter = $this->getFilter();
        return $filter( $handler( $list, $this ) );
    }

}
