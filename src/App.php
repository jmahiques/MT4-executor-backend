<?php

namespace App;

use App\EndPoint\EndPoint;
use App\EndPoint\OpenPositionEndPoint;
use App\EndPoint\ProbeEndPoint;
use App\EndPoint\TickEndPoint;
use App\EndPoint\UserUpdateLevelEndPoint;
use App\Repository\PositionRepository;
use App\Router\Router;
use App\Storage\RedisStorage;
use App\Storage\StorageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    private $router;
    private $storage;

    public function __construct(string $root, ?StorageInterface $storage = null) 
    {
        $this->router = new Router($root, [
            OpenPositionEndPoint::class,
            ProbeEndPoint::class,
            TickEndPoint::class,
            UserUpdateLevelEndPoint::class,
        ]);
        $this->storage = $storage ?? new RedisStorage();
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        /** @var EndPoint $handler */
        $handlerClass = $this->router->match($request->getUri()->getPath());

        $handler = new $handlerClass();
        $handler->configureRepository(new PositionRepository($this->storage));
        return $handler->execute($request);
    }
}
