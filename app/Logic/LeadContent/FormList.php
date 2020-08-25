<?php
namespace App\Logic\LeadContent;

/**
 * 输入框
 */
abstract class FormList extends FormRow
{
    //选项
    protected $options = [];
    //选中键
    protected $selected_key = "checked";

    protected function in_value( $val ) {
        $value = $this->getValue();
        $val_array = empty( $value )? []: \explode( ",", $value );

        return \in_array( $val, $val_array );
    }
    
    public function getOptions( ) {
        $options = $this->options;
        foreach ($options as $key => &$option) {
            if( $this->in_value( $key ) ) {
                $option['attr'][ $this->getSelectedKey() ] = "";
            }
        }

        return $options;
    }

    public function setOptions( array $options ) {
        $push_num = 0;
        foreach ($options as $key => $value) {
            // if( !\is_string( $value ) ) continue;
            $this->pushOptions( $key, $value );
            $push_num++;
        }

        return $push_num;
    }

    public function pushOptions( string $key, string $val, array $attr = [] ) {
        foreach ($attr as $ak => $av) {
            if( \in_array( $ak, static::NOT_USE_ATTR ) || $ak == $this->getSelectedKey() ) {
                unset( $attr[ $ak ] );
            }
        }
        $this->options[ $key ] = [ "value" => $val, "attr" => $attr ];
    }

    public function getSelectedKey() {
        return $this->selected_key;
    }

}
