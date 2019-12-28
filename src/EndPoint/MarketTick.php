<?php

namespace App\EndPoint;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MarketTick implements EndPointInterface
{
    public function execute(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(200, ['Content-Type' => 'text/plain'], 'TICK');
    }
}
