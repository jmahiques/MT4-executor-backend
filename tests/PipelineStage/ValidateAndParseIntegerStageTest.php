<?php

use App\Communication\RequestParam;
use App\PipelineStage\ValidateAndParseIntegerStage;
use PHPUnit\Framework\TestCase;

class ValidateAndParseIntegerStageTest extends TestCase
{
    public function testValidValue()
    {
        $stage = new ValidateAndParseIntegerStage(RequestParam::MAGIC_NUMBER);
        $payload = $stage([RequestParam::MAGIC_NUMBER => '123']);

        self::assertEquals(123, $payload[RequestParam::MAGIC_NUMBER]);
    }

    public function testMissingValueOnPayload()
    {
        $stage = new ValidateAndParseIntegerStage(RequestParam::MAGIC_NUMBER);

        self::expectExceptionMessage('The value for key MAGIC_NUMBER must be sent');
        $stage(['key' => '123']);
    }

    public function testInvalidInput()
    {
        $stage = new ValidateAndParseIntegerStage(RequestParam::MAGIC_NUMBER);

        self::expectExceptionMessage('The key MAGIC_NUMBER must be a integer');
        $stage([RequestParam::MAGIC_NUMBER => 'asd']);
    }
}
