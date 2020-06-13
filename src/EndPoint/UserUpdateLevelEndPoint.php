<?php

namespace App\EndPoint;

use App\Command\UserUpdateLevelCommand;
use App\Communication\CommunicationResponse;
use App\Communication\RequestParam;
use App\Entity\Position;
use App\PipelineStage\CreateUserUpdateLevelCommandStage;
use App\PipelineStage\ValidateAndParseFloatStage;
use App\PipelineStage\ValidateAndParseIntegerStage;
use League\Pipeline\StageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserUpdateLevelEndPoint extends EndPoint
{
    /** @return StageInterface[] */
    protected function getStages(): array
    {
        return [
            new ValidateAndParseIntegerStage(RequestParam::MAGIC_NUMBER),
            new ValidateAndParseIntegerStage(RequestParam::TICKET),
            new ValidateAndParseFloatStage(RequestParam::LEVEL_STOP),
            new ValidateAndParseFloatStage(RequestParam::LEVEL_PARTIAL_STOP),
            new ValidateAndParseFloatStage(RequestParam::LEVEL_PROFIT),
            new ValidateAndParseFloatStage(RequestParam::LEVEL_PARTIAL_PROFIT),
            new CreateUserUpdateLevelCommandStage(),
        ];
    }

    /**
     * @param ServerRequestInterface $request
     * @param UserUpdateLevelCommand $command
     * @return ResponseInterface
     */
    protected function handle(ServerRequestInterface $request, $command): ResponseInterface
    {
        $position = $this->repository->get($command->getMagicNumber(), $command->getTicket());

        if (!$position instanceof Position) {
            return CommunicationResponse::NOT_FOUND();
        }

        $position->updateStopLevel($command->getStopPrice());
        $position->updatePartialStopLevel($command->getPartialStopPrice());
        $position->updateProfitLevel($command->getProfitPrice());
        $position->updatePartialProfitLevel($command->getPartialProfitPrice());

        $this->repository->save($position);

        return CommunicationResponse::OK();
    }

    public static function getUri(): string
    {
        return '/levels';
    }
}
