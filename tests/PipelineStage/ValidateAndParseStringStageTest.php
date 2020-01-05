<?php

use App\Communication\RequestParam;
use App\PipelineStage\ValidateAndParseStringStage;
use PHPUnit\Framework\TestCase;

class ValidateAndParseStringStageTest extends TestCase
{
    public function testValidValue()
    {
        $stage = new ValidateAndParseStringStage(RequestParam::INSTRUMENT);
        $payload = $stage([RequestParam::INSTRUMENT => 'EURUSD']);

        self::assertEquals('EURUSD', $payload[RequestParam::INSTRUMENT]);
    }

    public function testMissingValueOnPayload()
    {
        $stage = new ValidateAndParseStringStage(RequestParam::INSTRUMENT);

        self::expectExceptionMessage('The value for key INSTRUMENT must be sent');
        $stage(['key' => 'EURUSD']);
    }

    public function testInvalidInput()
    {
        $stage = new ValidateAndParseStringStage(RequestParam::INSTRUMENT);

        self::expectExceptionMessage('The key INSTRUMENT must be a string');
        $stage([RequestParam::INSTRUMENT => null]);
    }
}
