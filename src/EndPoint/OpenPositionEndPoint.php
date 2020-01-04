<?php

namespace App\EndPoint;

use App\Communication\RequestParams;
use App\DTO\OpenPosition;
use App\PipelineStage\DtoValueMapper;
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
            new DtoValueMapper(RequestParams::MAGIC_NUMBER, 'magicNumber', 'The magic number must be sent'),
            new DtoValueMapper(RequestParams::TICKET, 'ticket', 'The ticket must be sent'),
            new DtoValueMapper(RequestParams::OPEN_PRICE, 'openPrice', 'The ticket must be sent'),
            new DtoValueMapper(RequestParams::OPEN_TIME, 'openTime', 'The ticket must be sent'),
            new DtoValueMapper(RequestParams::INSTRUMENT, 'instrument', 'The ticket must be sent'),
            new DtoValueMapper(RequestParams::DIGITS, 'digits', 'The ticket must be sent'),
            new DtoValueMapper(RequestParams::LOTS, 'lots', 'The ticket must be sent'),
        ];
    }

    protected function createDto()
    {
        return new OpenPosition();
    }

    protected function handle(ServerRequestInterface $request, $dto): ResponseInterface
    {
        return new Response(200, ['Content-Type' => 'text/plain'], 'OPEN');
    }
}
