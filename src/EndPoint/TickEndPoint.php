<?php

namespace App\EndPoint;

use App\Command\TickCommand;
use App\Communication\RequestParam;
use App\Communication\CommunicationResponse;
use App\Entity\Position;
use App\PipelineStage\CreateTickCommandStage;
use App\PipelineStage\ValidateAndParseFloatStage;
use App\PipelineStage\ValidateAndParseIntegerStage;
use League\Pipeline\StageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TickEndPoint extends EndPoint
{
    /** @return StageInterface[] */
    protected function getStages(): array
    {
        return [
            new ValidateAndParseIntegerStage(RequestParam::MAGIC_NUMBER),
            new ValidateAndParseIntegerStage(RequestParam::TICKET),
            new ValidateAndParseFloatStage(RequestParam::BID),
            new ValidateAndParseFloatStage(RequestParam::ASK),
            new CreateTickCommandStage()
        ];
    }

    /**
     * @param ServerRequestInterface $request
     * @param TickCommand $command
     * @return ResponseInterface
     */
    protected function handle(ServerRequestInterface $request, $command): ResponseInterface
    {
        try {
            $position = $this->repository->get($command->getMagicNumber(), $command->getTicket());

            if (!$position instanceof Position) {
                return CommunicationResponse::NOT_FOUND();
            }

            $response = CommunicationResponse::OK();

            $stop = $position->stopLevel();
            if (!$stop->hasReachedPrice() && $stop->reached($command->getBid())) {
                $response = CommunicationResponse::STOP_REACHED();
            }

            $profit = $position->profitLevel();
            if (!$profit->hasReachedPrice() && $profit->reached($command->getBid())) {
                $response = CommunicationResponse::PROFIT_REACHED();
            }

            $partialStop = $position->partialStopLevel();
            if (!$partialStop->hasReachedPrice() && $partialStop->reached($command->getBid())) {
                $response = CommunicationResponse::PARTIAL_STOP_REACHED();
            }

            $partialProfit = $position->partialProfitLevel();
            if (!$partialProfit->hasReachedPrice() && $partialProfit->reached($command->getBid())) {
                $response = CommunicationResponse::PARTIAL_PROFIT_REACHED();
            }

            $this->repository->save($position);
            return $response;
        } catch (\Exception $e) {
            /** @todo log error */
            return CommunicationResponse::INVALID_REQUEST($e->getMessage());
        }
    }
}
