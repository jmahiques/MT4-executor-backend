<?php

use App\Communication\RequestParams;
use App\DTO\OpenPosition;
use App\DTO\PipelineInfo;
use App\PipelineStage\MapFloatStage;
use PHPUnit\Framework\TestCase;

class MapFloatStageTest extends TestCase
{
    public function testValidValue()
    {
        $stage = new MapFloatStage(RequestParams::OPEN_PRICE, 'openPrice');
        $payload = $stage(new PipelineInfo([RequestParams::OPEN_PRICE => '1.2211'], new OpenPosition()));

        self::assertEquals(1.2211, $payload->dto->openPrice);
    }

    public function testMissingValueOnPayload()
    {
        $stage = new MapFloatStage(RequestParams::OPEN_PRICE, 'openPrice');

        self::expectExceptionMessage('The value for key openPrice must be sent');
        $stage(new PipelineInfo(['key' => '1.2121'], new OpenPosition()));
    }

    public function testInvalidInput()
    {
        $stage = new MapFloatStage(RequestParams::OPEN_PRICE, 'openPrice');

        self::expectExceptionMessage('The key openPrice must be a float');
        $stage(new PipelineInfo([RequestParams::OPEN_PRICE => 'asd'], new OpenPosition()));
    }
}
