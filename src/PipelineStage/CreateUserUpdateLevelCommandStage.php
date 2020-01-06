<?php

namespace App\PipelineStage;

use App\Command\UserUpdateLevelCommand;
use App\Communication\RequestParam;
use League\Pipeline\StageInterface;

class CreateUserUpdateLevelCommandStage implements StageInterface
{
    /**
     * @param array $payload
     * @return UserUpdateLevelCommand
     */
    public function __invoke($payload)
    {
        return new UserUpdateLevelCommand(
            $payload[RequestParam::MAGIC_NUMBER],
            $payload[RequestParam::TICKET],
            $payload[RequestParam::LEVEL_STOP],
            $payload[RequestParam::LEVEL_PARTIAL_STOP],
            $payload[RequestParam::LEVEL_PROFIT],
            $payload[RequestParam::LEVEL_PARTIAL_PROFIT]
        );
    }
}
