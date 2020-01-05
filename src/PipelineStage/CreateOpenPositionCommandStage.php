<?php

namespace App\PipelineStage;

use App\Communication\RequestParam;
use App\Command\OpenPositionCommand;
use League\Pipeline\StageInterface;

class CreateOpenPositionCommandStage implements StageInterface
{
    /**
     * @param array
     * @return OpenPositionCommand
     */
    public function __invoke($payload)
    {
        return new OpenPositionCommand(
            $payload[RequestParam::MAGIC_NUMBER],
            $payload[RequestParam::TICKET],
            $payload[RequestParam::OPEN_PRICE],
            $payload[RequestParam::OPEN_TIME],
            $payload[RequestParam::INSTRUMENT],
            $payload[RequestParam::DIGITS],
            $payload[RequestParam::LOTS],
            $payload[RequestParam::ORDER_TYPE],
            $payload[RequestParam::STOP],
            $payload[RequestParam::PARTIAL_STOP],
            $payload[RequestParam::PROFIT],
            $payload[RequestParam::PARTIAL_PROFIT]
        );
    }
}
