<?php

use App\Communication\RequestParam;
use App\PipelineStage\ValidateAndParseFloatStage;
use PHPUnit\Framework\TestCase;

class ValidateAndParseFloatStageTest extends TestCase
{
    public function testValidValue()
    {
        $stage = new ValidateAndParseFloatStage(RequestParam::OPEN_PRICE);
        $payload = $stage([RequestParam::OPEN_PRICE => '1.2211']);

        self::assertEquals(1.2211, $payload[RequestParam::OPEN_PRICE]);
    }

    public function testMissingValueOnPayload()
    {
        $stage = new ValidateAndParseFloatStage(RequestParam::OPEN_PRICE);

        self::expectExceptionMessage('The value for key OPEN_PRICE must be sent');
        $stage(['key' => '1.2121']);
    }

    public function testInvalidInput()
    {
        $stage = new ValidateAndParseFloatStage(RequestParam::OPEN_PRICE);

        self::expectExceptionMessage('The key OPEN_PRICE must be a float');
        $stage([RequestParam::OPEN_PRICE => 'asd']);
    }
}
