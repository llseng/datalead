<?php
namespace App\Logic\LeadContent;

/**
 * 搜索输入框
 */
class TableFormInput extends FormInput
{

    /**
     * 构造函数
     */
    public function __construct( string $title, string $name, string $value = null ) {
        parent::__construct( $title, $name, $value );
        $this->setPlaceholder( $this->getTitle() );
    }
    
}
