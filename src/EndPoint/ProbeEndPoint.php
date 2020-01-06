<?php

namespace App\EndPoint;

use App\Communication\CommunicationResponse;
use League\Pipeline\StageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ProbeEndPoint extends EndPoint
{
    /** @return StageInterface[] */
    protected function getStages(): array
    {
        return [];
    }

    protected function handle(ServerRequestInterface $request, $command): ResponseInterface
    {
        return CommunicationResponse::OK();
    }
}
