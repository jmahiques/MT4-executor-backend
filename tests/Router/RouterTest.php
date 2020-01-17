<?php

use App\EndPoint\NoEndPoint;
use App\EndPoint\OpenPositionEndPoint;
use App\EndPoint\ProbeEndPoint;
use App\EndPoint\TickEndPoint;
use App\EndPoint\UserUpdateLevelEndPoint;
use App\Router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @dataProvider getUris
     */
    public function test($uri, $expectedEndPoint)
    {
        $router = new Router('');
        self::assertInstanceOf($expectedEndPoint, $router->match($uri));
    }

    public function getUris()
    {
        return [
            ['/open', OpenPositionEndPoint::class],
            ['/probe', ProbeEndPoint::class],
            ['/tick', TickEndPoint::class],
            ['/levels', UserUpdateLevelEndPoint::class],
            ['/new-endpoint', NoEndPoint::class],
        ];
    }
}
