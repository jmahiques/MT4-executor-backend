<?php

namespace App\Router;

use App\EndPoint\EndPoint;
use App\EndPoint\NoEndPoint;
use App\EndPoint\OpenPositionEndPoint;
use App\EndPoint\ProbeEndPoint;

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
        }

        return new NoEndPoint();
    }
}
