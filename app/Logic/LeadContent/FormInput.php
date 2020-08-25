<?php
namespace App\Logic\LeadContent;

/**
 * 输入框
 */
class FormInput extends FormRow
{
    //行类型
    protected $row_type = "input";

    protected $def_attr = [ "type" => "text" ];

    public function inputType( $type ) {
        $this->pushDefAttr("type", $type );
    }

}
