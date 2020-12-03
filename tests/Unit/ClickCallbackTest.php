<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Logic\AppData\Click\Callback\Callback;
use App\Logic\AppData\Click\Callback\ByteStrategy;
use App\Logic\AppData\Click\Callback\KuaiShouStrategy;
use App\Logic\AppData\Click\Callback\TxadStrategy;

class ClickCallbackTest extends TestCase
{
    private $callback;

    public function setUp( ) {
        $this->callback = new Callback( "test" );
        $this->callback->setData( [
            "callback_url" => "http://127.0.0.1"
        ] );
    }

    /**
     * 测试默认策略
     *
     * @return void
     */
    public function testDefStrategy()
    {
        $this->assertEquals( ['event_type' => 0], $this->callback->init());
        $this->assertEquals( ['event_type' => 1], $this->callback->register());
        $this->assertEquals( ['event_type' => 6], $this->callback->keep2());
    }

    /**
     * 测试头条策略
     *
     * @return void
     */
    public function testByteStrategy()
    {
        $this->callback->setStrategy( new ByteStrategy() );
        $this->assertEquals( ['event_type' => 0], $this->callback->init());
        $this->assertEquals( ['event_type' => 1], $this->callback->register());
        $this->assertEquals( ['event_type' => 6], $this->callback->keep2());
    }

    /**
     * 测试快手策略
     *
     * @return void
     */
    public function testKuaiShouStrategy()
    {
        $this->callback->setStrategy( new KuaiShouStrategy() );
        $this->assertEquals( 1, $this->callback->init()['event_type'] );
        $this->assertEquals( 2, $this->callback->register()['event_type'] );
        $this->assertEquals( 7, $this->callback->keep2()['event_type'] );
    }

    /**
     * 测试腾讯策略
     *
     * @return void
     */
    public function testTxadStrategy()
    {
        $this->callback->setStrategy( new TxadStrategy() );
        $this->assertEquals( [], $this->callback->init());
        $this->assertEquals( [], $this->callback->register());
        $this->assertEquals( [], $this->callback->keep2());
    }

}
