<?php
namespace App\Logic\LeadContent;

/**
 * 内容页-表单类
 */
class Table extends Content
{

    /**
     * 输入行列表
     *
     * @var array
     */
    protected $rows = [];

    /**
     * 展示列列表
     * 
     * @var array
     */
    protected $lines = [];

    /**
     * 展示列列表
     * 
     * @var array
     */
    protected $data = [];

    /**
     * 分页样式
     *
     * @var mixed
     */
    protected $pages;

    /**
     * 分页实例
     *
     * @var Illuminate\Pagination\AbstractPaginator
     */
    protected $paginator;

    /**
     * 主键
     *
     * @var string
     */
    protected $pkey = "id";

    /**
     * 构造函数
     */
    public function __construct( string $title = "列表", string $pkey = null ) {
        $this->setTitle( $title );
        !\is_null( $pkey ) && $this->setPkey( $pkey );
    }

    
    public function setPkey( string $pkey ) {
        $this->pkey = $pkey;
    }

    public function getPkey( ) {
        return $this->pkey;
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
     * 添加列表列
     *
     * @param TableLine $line
     * @return void
     */
    public function pushLine( TableLine $line ) {
        return \array_push( $this->lines, $line );
    }

    /**
     * 尾部弹出输入行
     *
     * @param TableLine $line
     * @return void
     */
    public function popLine( TableLine $line ) {
        return \array_pop( $this->lines, $line );
    }

    /**
     * 头部插入输入行
     *
     * @param TableLine $line
     * @return void
     */
    public function unshiftLine( TableLine $line ) {
        return \array_unshift( $this->lines, $line );
    }

    /**
     * 头部弹出输入行
     *
     * @param TableLine $line
     * @return void
     */
    public function shiftLine( TableLine $line ) {
        return \array_shift( $this->lines, $line );
    }

    /**
     * 设置列表列
     *
     * @param TableLine $line
     * @return void
     */
    public function setLines( array $lines ) {
        $push_num = 0;
        foreach ($lines as $line) {
            if( $line INSTANCEOF TableLine ) {
                $this->pushLine( $line );
                $push_num++;
            }
        }
        
        return $push_num;
    }

    public function getLines( ) {
        return $this->lines;
    }

    /**
     * 设置表数据
     *
     * @param array $data
     * @return void
     */
    public function setData( array $data ) {
        $this->data = $data;
    }

    public function getData( ) {
        return $this->data;
    }

    /**
     * 设置分页样式
     *
     * @param mixed $pages
     * @return mixed
     */
    public function setPages( $pages ) {
        $this->pages = $pages;
    }

    public function getPages( ) {
        return isset( $this->pages )? $this->pages: "";
    }

    /**
     * 设置分页实例
     *
     * @param Illuminate\Pagination\AbstractPaginator $paginator
     * @return void
     */
    public function setPaginator( \Illuminate\Pagination\AbstractPaginator $paginator ) {
        $this->paginator = $paginator;
        $this->setData( $this->paginator->toArray()['data'] );
        $this->setPages( $this->paginator->links() );
    }

    public function getPaginator( ) {
        return isset( $this->paginator )? $this->paginator: null;
    }

    protected $formBlock = true;

    /**
     * 设置提交按钮
     *
     * @param bool $bool
     * @return void
     */
    public function setFormBlock( $bool ) {
        $this->formBlock = $bool? true: false;
    }
    
    public function getFormBlock( ) {
        return $this->formBlock;
    }

    public function noFormBlock( ) {
        $this->setFormBlock( false );
    }


    /**
     * 渲染页面
     *
     * @param array $data
     * @return void
     */
    public function view( array $data = null ) {
        $view_data = \is_null( $data )? []: $data;
        $view_data['LCtable'] = $this;
        $view_data['LCdata'] = $this->getData();
        $view_data['LCpages'] = $this->getPages();

        return \view( "leadcontent.table", $view_data );
    }

}