<?php

use App\Communication\RequestParams;
use App\DTO\OpenPosition;
use App\DTO\PipelineInfo;
use App\PipelineStage\MapIntegerStage;
use PHPUnit\Framework\TestCase;

class MapIntegerStageTest extends TestCase
{
    public function testValidValue()
    {
        $stage = new MapIntegerStage(RequestParams::MAGIC_NUMBER, 'magicNumber');
        $payload = $stage(new PipelineInfo([RequestParams::MAGIC_NUMBER => '123'], new OpenPosition()));

        self::assertEquals(123, $payload->dto->magicNumber);
    }

    public function testMissingValueOnPayload()
    {
        $stage = new MapIntegerStage(RequestParams::MAGIC_NUMBER, 'magicNumber');

        self::expectExceptionMessage('The value for key magicNumber must be sent');
        $stage(new PipelineInfo(['key' => '123'], new OpenPosition()));
    }

    public function testInvalidInput()
    {
        $stage = new MapIntegerStage(RequestParams::MAGIC_NUMBER, 'magicNumber');

        self::expectExceptionMessage('The key magicNumber must be a integer');
        $stage(new PipelineInfo([RequestParams::MAGIC_NUMBER => 'asd'], new OpenPosition()));
    }
}
