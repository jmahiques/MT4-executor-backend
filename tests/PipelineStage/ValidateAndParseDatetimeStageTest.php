<?php

use App\Communication\RequestParam;
use App\DTO\OpenPositionCommand;
use App\DTO\PipelineInfo;
use App\PipelineStage\ValidateAndParseDatetimeStage;
use PHPUnit\Framework\TestCase;

class ValidateAndParseDatetimeStageTest extends TestCase
{
    public function testValidValue()
    {
        $stage = new ValidateAndParseDatetimeStage(RequestParam::OPEN_TIME);
        $payload = $stage([RequestParam::OPEN_TIME => '2019.08.08 12:12:04']);

        self::assertInstanceOf(\DateTime::class, $payload[RequestParam::OPEN_TIME]);
        self::assertEquals('2019.08.08 12:12:04', $payload[RequestParam::OPEN_TIME]->format('Y.m.d H:i:s'));
    }

    public function testMissingValueOnPayload()
    {
        $stage = new ValidateAndParseDatetimeStage(RequestParam::OPEN_TIME);

        self::expectExceptionMessage('The value for key OPEN_TIME must be sent');
        $stage(['key' => '2019.08.08 12:12:04']);
    }

    public function testInvalidInput()
    {
        $stage = new ValidateAndParseDatetimeStage(RequestParam::OPEN_TIME);

        self::expectExceptionMessage('The key OPEN_TIME must be a datetime object');
        $stage([RequestParam::OPEN_TIME => 'asd']);
    }
}
