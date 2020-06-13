<?php

namespace App\Router;

use App\EndPoint\EndPoint;
use App\EndPoint\NoEndPoint;

class Router
{
    private $root;
    /** @var EndPoint[] */
    private $handlerRoutes;

    public function __construct(string $root, array $handlerRoutes)
    {
        $this->root = $root;
        $this->handlerRoutes = $handlerRoutes;
    }

    public function match(string $url): string
    {
        foreach ($this->handlerRoutes as $handler) {
            if ($this->root . $handler::getUri() === $url) {
                return $handler;
            }
        }

        return NoEndPoint::class;
    }
}
