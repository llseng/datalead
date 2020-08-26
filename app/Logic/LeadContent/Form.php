<?php
namespace App\Logic\LeadContent;

/**
 * 内容页-表单类
 */
class Form extends Content
{
    /**
     * 提交模式
     *
     * @var string
     */
    protected $method = "GET";

    /**
     * 提交地址
     *
     * @var [type]
     */
    protected $action = "#";

    /**
     * 输入行列表
     *
     * @var array
     */
    protected $rows = [];

    /**
     * 提交按钮
     *
     * @var boolean
     */
    protected $submitBtn = true;
    protected $submitBtnName = "Save Changes";

    /**
     * 隐藏数据
     *
     * @var array
     */
    protected $hideData = [];

    /**
     * 构造函数
     */
    public function __construct( string $title = "表单", string $method = null, string $action = null ) {
        $this->setTitle( $title );
        !\is_null( $method ) && $this->setMethod( $method );
        !\is_null( $action ) && $this->setAction( $action );
    }

    /**
     * 设置请求模式
     *
     * @param string $method
     * @return void
     */
    public function setMethod( string $method ) {
        $this->method = \strtoupper( $method );
    }

    public function getMethod( ) {
        return $this->method;
    }

    /**
     * 设置提交地址
     *
     * @param string $action
     * @return void
     */
    public function setAction( string $action ) {
        $this->action = $action;
    }

    public function getAction( ) {
        return $this->action;
    }

    /**
     * 添加输入行
     *
     * @param FormRow $row
     * @return void
     */
    public function pushRow( FormRow $row ) {
        return \array_push( $this->rows, $row );
    }

    /**
     * 尾部弹出输入行
     *
     * @param FormRow $row
     * @return void
     */
    public function popRow( FormRow $row ) {
        return \array_pop( $this->rows, $row );
    }

    /**
     * 头部插入输入行
     *
     * @param FormRow $row
     * @return void
     */
    public function unshiftRow( FormRow $row ) {
        return \array_unshift( $this->rows, $row );
    }

    /**
     * 头部弹出输入行
     *
     * @param FormRow $row
     * @return void
     */
    public function shiftRow( FormRow $row ) {
        return \array_shift( $this->rows, $row );
    }

    public function setRows( array $rows ) {
        $push_num = 0;
        foreach ($rows as $row) {
            if( $row INSTANCEOF FormRow ) {
                $this->pushRow( $row );
                $push_num++;
            }
        }
        
        return $push_num;
    }

    public function getRows( ) {
        return $this->rows;
    }

    /**
     * 设置提交按钮
     *
     * @param bool $bool
     * @return void
     */
    public function setSubmitBtn( $bool ) {
        $this->submitBtn = $bool? true: false;
    }
    
    public function getSubmitBtn( ) {
        return $this->submitBtn;
    }

    public function noSubmitBtn( ) {
        $this->setSubmitBtn( false );
    }

    /**
     * 设置提交按钮名
     *
     * @param string $name
     * @return void
     */
    public function setSubmitBtnName( string $name ) {
        $this->submitBtnName = $name;
    }

    public function getSubmitBtnName( ) {
        return $this->submitBtnName;
    }

    /**
     * 设置隐藏数据
     *
     * @param array $data
     * @return int
     */
    public function setHideData( array $data ) {
        $push_num = 0;
        foreach ($data as $key => $val) {
            if( !\is_string( $key ) ) continue;
            $this->pushHideData( $key, $val );
            $push_num++;
        }

        return $push_num;
    }

    public function pushHideData( string $key, $val ) {
        $this->hideData[ $key ] = $val;
    }

    public function getHideData( ) {
        return $this->hideData;
    }

    /**
     * 渲染页面
     *
     * @param array $data
     * @return void
     */
    public function view( array $data = null ) {
        $view_data = \is_null( $data )? []: $data;
        $view_data['LCform'] = $this;

        return \view( "leadcontent.form", $view_data );
    }
}
