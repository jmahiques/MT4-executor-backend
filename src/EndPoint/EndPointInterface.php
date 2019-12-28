<?php

namespace App\EndPoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface EndPointInterface
{
    public function execute(ServerRequestInterface $request): ResponseInterface;
}
