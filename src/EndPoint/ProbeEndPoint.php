<?php

namespace App\EndPoint;

use League\Pipeline\StageInterface;
use Nyholm\Psr7\Response;
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
        return new Response(200);
    }
}
