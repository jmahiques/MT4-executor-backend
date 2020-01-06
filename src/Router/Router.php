<?php

namespace App\Router;

use App\EndPoint\EndPoint;
use App\EndPoint\NoEndPoint;
use App\EndPoint\OpenPositionEndPoint;
use App\EndPoint\ProbeEndPoint;
use App\EndPoint\TickEndPoint;

class Router
{
    private $root;

    public function __construct(string $root)
    {
        $this->root = $root;
    }

    public function match(string $url): EndPoint
    {
        if ($url === $this->root.'/open') {
            return new OpenPositionEndPoint();
        } elseif ($url === $this->root.'/probe') {
            return new ProbeEndPoint();
        } elseif ($url === $this->root.'/tick') {
            return new TickEndPoint();
        }

        return new NoEndPoint();
    }
}
