<?php

use App\Communication\CommunicationResponse;
use App\Router\Router;
use App\Storage\InMemoryStorage;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Server as ReactPHPServer;

require_once __DIR__ . '/vendor/autoload.php';

$storage = new InMemoryStorage();
$loop = Factory::create();
$loop->addSignal(SIGTERM, function (int $signal) use ($storage) {
    $storage->flush();
    printf('REACHED SIGTERM AT: %s', (new \DateTime('now'))->format('U'));
});

$server = new ReactPHPServer(function (ServerRequestInterface $serverRequest) use($storage) {
    try {
        return (new Router('/react.php'))
            ->match($serverRequest->getUri()->getPath())
            ->configureRepository($storage)
            ->execute($serverRequest);
    } catch (\Exception $e) {
        return CommunicationResponse::INVALID_REQUEST($e->getMessage());
    }
});

$server->on('error', function (\Throwable $e) {
    printf('Error: %s -- %s', $e->getMessage(), $e->getTraceAsString());
    printf('File: %s Line: %s Code: %s', $e->getFile(), $e->getLine(), $e->getCode());
});

$socket = new \React\Socket\Server('0.0.0.0:8080', $loop);
$server->listen($socket);

$loop->run();
