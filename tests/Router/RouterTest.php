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
    public function test($uri, $routeHandlers, $expectedEndPoint)
    {
        $router = new Router('', $routeHandlers);
        self::assertEquals($expectedEndPoint, $router->match($uri));
    }

    public function getUris()
    {
        return [
            ['/open', [OpenPositionEndPoint::class], OpenPositionEndPoint::class],
            ['/probe', [ProbeEndPoint::class], ProbeEndPoint::class],
            ['/tick', [TickEndPoint::class], TickEndPoint::class],
            ['/levels', [UserUpdateLevelEndPoint::class], UserUpdateLevelEndPoint::class],
            ['/new-endpoint', [], NoEndPoint::class],
        ];
    }
}
