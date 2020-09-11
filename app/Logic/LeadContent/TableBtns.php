<?php
namespace App\Logic\LeadContent;

/**
 * 输入框
 */
class TableBtns extends TableLine
{

    /**
     * 按钮类型列表
     *
     * @var array
     */
    static public $btn_type_list = [
        "success" => "btn-success",
        "succ" => "btn-success", //success 别名
        "info" => "btn-info",
        "warning" => "btn-warning",
        "warn" => "btn-warning", //warning 别名
        "danger" => "btn-danger",
        "error" => "btn-danger", //danger 别名
        "dark" => "btn-dark",
        "light" => "btn-light",
    ];

    /**
     * 是否是规定类型
     *
     * @param string $type
     * @return void
     */
    static public function isBtnType( string $type ) {
        $btn_types = \array_keys( static::$btn_type_list );
        if( !\in_array( $type, $btn_types ) ) {
            return false;
        }

        return true;
    }

    protected $btns = [];

    /**
     * 构造函数
     */
    public function __construct( string $title, string $name ) {
        parent::__construct( $title, $name );
        $this->setLineType( "btns" );
        $this->pushDefAttr( 'class', $this->getName(). "-btns" );
    }

    public function pushBtn( string $info, string $name, string $type = null ) {
        if( \is_null( $type ) || !static::isBtnType( $type ) ) {
            $type = "light";
        }

        $btn_info = [
            "info" => $info,
            "name" => $name,
            "type" => static::$btn_type_list[ $type ]
        ];

        return \array_push( $this->btns, $btn_info );
    }

    public function getBtns( ) {
        return $this->btns;
    }

}
