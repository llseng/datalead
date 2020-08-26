<?php
namespace App\Logic\LeadContent;

/**
 * undocumented class
 */
abstract class Content
{

    const SOURCE_TYPES = ["js", "css"];

    /**
     * 标题
     *
     * @var string
     */
    protected $title;

    public function setTitle( string $title ) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    /**
     * 资源
     *
     * @var array
     */
    protected $sources = [];

    /**
     * 设置资源
     *
     * @param string $type
     * @param array $paths
     * @return bool|int
     */
    public function setSources( string $type, array $paths ) {
        if( !\in_array( $type, static::SOURCE_TYPES ) ) {
            return false;
        }
        $paths = \array_unique( $paths );
        $push_num = 0;
        foreach ($paths as $path) {
            if( !\is_string( $path ) ) continue;
            $this->pushSource( $type, $path );
            $push_num++;
        }

        return $push_num;
    }

    /**
     * 添加资源
     *
     * @param string $type
     * @param string $path
     * @return bool
     */
    public function pushSource( string $type, string $path ) {
        if( !\in_array( $type, static::SOURCE_TYPES ) ) {
            return false;
        }
        $paths = \array_column( $this->getSource(), "path" );
        //存在则无需添加
        if( \in_array( $path, $paths ) ) {
            return false;
        }
        $li = [ "type" => $type, "path" => $path ];
        return \array_push( $this->sources, $li );
    }

    public function getSources( ) {
        return $this->sources;
    }

}
