<?php

use App\Communication\RequestParams;
use App\DTO\OpenPosition;
use App\DTO\PipelineInfo;
use App\Entity\Position;
use App\PipelineStage\MapBelongsToCollectionStage;
use PHPUnit\Framework\TestCase;

class MapBelongsToCollectionStageTest extends TestCase
{
    public function testValidValue()
    {
        $stage = new MapBelongsToCollectionStage(RequestParams::ORDER_TYPE, 'type', Position::getPositionTypes());
        $payload = $stage(new PipelineInfo([RequestParams::ORDER_TYPE => Position::TYPE_BUY], new OpenPosition()));

        self::assertEquals(Position::TYPE_BUY, $payload->dto->type);
    }

    public function testMissingValueOnPayload()
    {
        $stage = new MapBelongsToCollectionStage(RequestParams::ORDER_TYPE, 'type', Position::getPositionTypes());

        self::expectExceptionMessage('The value for key type must be sent');
        $stage(new PipelineInfo(['key' => Position::TYPE_BUY], new OpenPosition()));
    }

    public function testInvalidInput()
    {
        $stage = new MapBelongsToCollectionStage(RequestParams::ORDER_TYPE, 'type', Position::getPositionTypes());

        self::expectExceptionMessage('The type must be in ['.implode(',', Position::getPositionTypes()).']');
        $stage(new PipelineInfo([RequestParams::ORDER_TYPE => 'asd'], new OpenPosition()));
    }
}
