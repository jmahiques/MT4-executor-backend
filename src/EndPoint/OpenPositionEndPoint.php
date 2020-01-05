<?php

namespace App\EndPoint;

use App\Communication\RequestParam;
use App\Command\OpenPositionCommand;
use App\Entity\Position;
use App\PipelineStage\CreateOpenPositionCommandStage;
use App\PipelineStage\ValidateAndParseDatetimeStage;
use App\PipelineStage\ValidateAndParseFloatStage;
use App\PipelineStage\ValidateAndParseIntegerStage;
use App\PipelineStage\ValidateAndParseStringStage;
use App\Strategy\DefaultStrategy;
use League\Pipeline\StageInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class OpenPositionEndPoint extends EndPoint
{
    /** @return StageInterface[] */
    protected function getStages(): array
    {
        return [
            new ValidateAndParseIntegerStage(RequestParam::TICKET),
            new ValidateAndParseIntegerStage(RequestParam::MAGIC_NUMBER),
            new ValidateAndParseFloatStage(RequestParam::OPEN_PRICE),
            new ValidateAndParseDatetimeStage(RequestParam::OPEN_TIME),
            new ValidateAndParseStringStage(RequestParam::INSTRUMENT),
            new ValidateAndParseIntegerStage(RequestParam::DIGITS),
            new ValidateAndParseFloatStage(RequestParam::LOTS),
            new ValidateAndParseStringStage(RequestParam::ORDER_TYPE),
            new ValidateAndParseIntegerStage(RequestParam::STOP),
            new ValidateAndParseIntegerStage(RequestParam::PARTIAL_STOP),
            new ValidateAndParseIntegerStage(RequestParam::PROFIT),
            new ValidateAndParseIntegerStage(RequestParam::PARTIAL_PROFIT),
            new CreateOpenPositionCommandStage()
        ];
    }

    /**
     * @param ServerRequestInterface $request
     * @param OpenPositionCommand $command
     * @return ResponseInterface
     */
    protected function handle(ServerRequestInterface $request, $command): ResponseInterface
    {
        try {
            $strategy = DefaultStrategy::fromCommand($command);
            $position = Position::fromCommand(
                $command,
                $strategy->computeStopLevel($command),
                $strategy->computePartialStopLevel($command),
                $strategy->computeProfitLevel($command),
                $strategy->computePartialProfitLevel($command)
            );
            /** @todo LOG entity creation */
            $this->repository->save($position);

            return new Response(200, ['Content-Type' => 'text/plain'], $position->notifyLevels());
        } catch (\Exception $e) {
            /** @todo log error */
            return new Response(406, ['Content-Type' => 'text/plain'], $e->getMessage());
        }
    }
}
