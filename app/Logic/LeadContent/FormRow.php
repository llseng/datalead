<?php
namespace App\Logic\LeadContent;

/**
 * 表单输入行
 */
abstract class FormRow
{
    const EMPTY = "";

    const ROW_TYPES = ["input", "textarea", "checkbox", "radio", "select"];

    const NOT_USE_ATTR = [ "name", "value", "class" ];

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
     * 键值
     *
     * @var string
     */
    protected $value;

    /**
     * 提示
     *
     * @var string
     */
    protected $prompt;

    /**
     * 介绍
     *
     * @var string
     */
    protected $intro;

    /**
     * 错误介绍
     *
     * @var string
     */
    protected $err_intro;

    /**
     * 构造函数
     */
    public function __construct( string $title, string $name, string $value = null ) {
        $this->setTitle( $title );
        $this->setName( $name );
        is_null( $value ) || $this->setValue( $value );
    }

    public function setTitle( string $title ) {
        $this->title = $title;
    }

    public function setName( string $name ) {
        $this->name = $name;
    }

    public function setValue( string $value ) {
        $this->value = $value;
    }

    public function setPrompt( string $prompt ) {
        $this->prompt = $prompt;
    }

    public function setintro( string $intro ) {
        $this->intro = $intro;
    }

    public function setErrIntro( string $err_intro ) {
        $this->err_intro = $err_intro;
    }

    public function getTitle( ) {
        return isset( $this->title )?$this->title : static::EMPTY;
    }

    public function getName( ) {
        return isset( $this->name )?$this->name : static::EMPTY;
    }

    public function getValue( ) {
        return isset( $this->value )?$this->value : static::EMPTY;
    }

    public function getPrompt( ) {
        return isset( $this->prompt )?$this->prompt : static::EMPTY;
    }

    public function getIntro( ) {
        return isset( $this->intro )?$this->intro : static::EMPTY;
    }

    public function getErrIntro( ) {
        return isset( $this->err_intro )?$this->err_intro : static::EMPTY;
    }

    //行类型
    protected $row_type;

    public function setRowType( string $row_type ) {
        if( !\in_array( $row_type, static::ROW_TYPES ) ) {
            return ;
        }

        $this->row_type = $row_type;
    }

    public function getRowType( ) {
        return $this->row_type;
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

    /**
     * 预期值提示
     *
     * @param string $value
     * @return void
     */
    public function setPlaceholder( $value ) {
        return $this->pushDefAttr( "placeholder", $value );
    }
    
    /**
     * 禁用当前行
     */
    public function disabled( ) {
        return $this->pushDefAttr( "disabled", "" );
    }
}
