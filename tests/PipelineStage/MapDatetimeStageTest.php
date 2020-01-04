<?php

use App\Communication\RequestParams;
use App\DTO\OpenPosition;
use App\DTO\PipelineInfo;
use App\PipelineStage\MapDatetimeStage;
use PHPUnit\Framework\TestCase;

class MapDatetimeStageTest extends TestCase
{
    public function testValidValue()
    {
        $stage = new MapDatetimeStage(RequestParams::OPEN_TIME, 'openTime');
        $payload = $stage(new PipelineInfo([RequestParams::OPEN_TIME => '2019.08.08 12:12:04'], new OpenPosition()));

        self::assertInstanceOf(\DateTime::class, $payload->dto->openTime);
        self::assertEquals('2019.08.08 12:12:04', $payload->dto->openTime->format('Y.m.d H:i:s'));
    }

    public function testMissingValueOnPayload()
    {
        $stage = new MapDatetimeStage(RequestParams::OPEN_TIME, 'openTime');

        self::expectExceptionMessage('The value for key openTime must be sent');
        $stage(new PipelineInfo(['key' => '2019.08.08 12:12:04'], new OpenPosition()));
    }

    public function testInvalidInput()
    {
        $stage = new MapDatetimeStage(RequestParams::OPEN_TIME, 'openTime');

        self::expectExceptionMessage('The key openTime must be a datetime object');
        $stage(new PipelineInfo([RequestParams::OPEN_TIME => 'asd'], new OpenPosition()));
    }
}
