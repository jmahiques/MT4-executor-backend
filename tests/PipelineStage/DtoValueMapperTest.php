<?php

use App\Communication\RequestParams;
use App\DTO\OpenPosition;
use App\DTO\PipelineInfo;
use App\PipelineStage\DtoValueMapper;
use League\Pipeline\StageInterface;
use PHPUnit\Framework\TestCase;

class DtoValueMapperTest extends TestCase
{
    public function testValidValues()
    {
        $stage = new DtoValueMapper(RequestParams::MAGIC_NUMBER, 'magicNumber', 'Invalid input');
        self::assertInstanceOf(StageInterface::class, $stage);

        $payload = $stage(new PipelineInfo(
            [RequestParams::MAGIC_NUMBER => '123'],
            new OpenPosition()
        ));
        self::assertEquals(123, $payload->dto->magicNumber);
    }

    public function testException()
    {
        $stage = new DtoValueMapper(RequestParams::MAGIC_NUMBER, 'magicNumber', 'Invalid input');

        self::expectExceptionMessage('Invalid input');
        $stage(new PipelineInfo(
            ['someKey' => 123],
            new OpenPosition()
        ));
    }
}
