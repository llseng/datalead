<?php
namespace App\Logic\LeadContent;

/**
 * 输入框
 */
class FormSelect extends FormList
{
    //行类型
    protected $row_type = "select";
    //选中键
    protected $selected_key = "selected";

    public function multiple() {
        $this->pushDefAttr( "multiple", "" );
    }

    public function isMultiple() {
        $def_attr = $this->getDefAttr();
        $def_attr_keys = \array_keys( $def_attr );

        return \in_array( "multiple", $def_attr_keys );
    }
}
