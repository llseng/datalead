<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Logic\AppData\Click\ByteData;
use App\Logic\AppData\Click\KuaiShouData;
use App\Logic\AppData\Click\TxadData;

class ClickDataTest extends TestCase
{
    /**
     * 测试ByteData.
     *
     * @return void
     */
    public function testByteData()
    {
        $data = new ByteData( [] );
        $this->assertArrayHasKey( "unique_id", $data->getData() );
    }
    /**
     * 测试KuaiShouData.
     *
     * @return void
     */
    public function testKuaiShouData()
    {
        $data = new KuaiShouData( [] );
        $this->assertArrayHasKey( "unique_id", $data->getData() );
    }
    /**
     * 测试TxadData.
     *
     * @return void
     */
    public function testTxadData()
    {
        $data = new TxadData( [] );
        $this->assertArrayHasKey( "unique_id", $data->getData() );
    }
}
