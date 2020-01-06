<?php

namespace App\PipelineStage;

use App\Command\TickCommand;
use App\Communication\RequestParam;
use League\Pipeline\StageInterface;

class CreateTickCommandStage implements StageInterface
{
    /**
     * @param array $payload
     * @return TickCommand
     */
    public function __invoke($payload)
    {
        return new TickCommand(
            $payload[RequestParam::MAGIC_NUMBER],
            $payload[RequestParam::TICKET],
            $payload[RequestParam::BID],
            $payload[RequestParam::ASK]
        );
    }
}
