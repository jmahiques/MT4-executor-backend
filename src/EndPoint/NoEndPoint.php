<?php

namespace App\EndPoint;

use League\Pipeline\StageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class NoEndPoint extends EndPoint
{
    /** @return StageInterface[] */
    protected function getStages(): array
    {
        return [];
    }

    protected function handle(ServerRequestInterface $request, $command): ResponseInterface
    {
        return new Response(404);
    }
}
