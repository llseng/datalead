<?php
namespace App\Logic\LeadContent;

/**
 * 表单输入行
 */
abstract class TableLine
{
    const EMPTY = "";
    const LINE_TYPES = ["info", "btns"];
    const NOT_USE_ATTR = [ "id" ];


    /**
     * 标题
     *
     * @var string
     */
    protected $title;
    
    /**
     * 键名
     *
     * @var string
     */
    protected $name;

    /**
     * 构造函数
     */
    public function __construct( string $title, string $name ) {
        $this->setTitle( $title );
        $this->setName( $name );
    }

    public function setName( string $name ) {
        $this->name = $name;
    }

    public function getName( ) {
        return isset( $this->name )?$this->name : static::EMPTY;
    }

    public function setTitle( string $title ) {
        $this->title = $title;
    }

    public function getTitle( ) {
        return isset( $this->title )?$this->title : static::EMPTY;
    }

    //列类型
    protected $line_type;

    public function setLineType( string $line_type ) {
        if( !\in_array( $line_type, static::LINE_TYPES ) ) {
            return ;
        }

        $this->line_type = $line_type;
    }

    public function getLineType( ) {
        return $this->line_type;
    }

    //默认属性
    protected $def_attr = [];

    public function getDefAttr( ) {
        return $this->def_attr;
    }
    
    public function pushDefAttr( string $key, string $val = null ) {
        if( \in_array( $key, static::NOT_USE_ATTR ) ) {
            return ;
        }
        $this->def_attr[ $key ] = $val;
    }

}