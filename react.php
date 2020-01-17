<?php

use App\Communication\CommunicationResponse;
use App\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Server as ReactPHPServer;

require_once __DIR__ . '/vendor/autoload.php';

$loop = Factory::create();
$server = new ReactPHPServer(function (ServerRequestInterface $serverRequest) {
    try {
        return (new Router('/react.php'))
            ->match($serverRequest->getUri()->getPath())
            ->execute($serverRequest);
    } catch (\Exception $e) {
        return CommunicationResponse::INVALID_REQUEST($e->getMessage());
    }
});

$server->on('error', function (\Throwable $e) {
    echo 'Error: ' . $e->getMessage() . ' --' . $e->getTraceAsString() . PHP_EOL;
    echo 'File: '.$e->getFile().' Line: '.$e->getLine().' Code: '.$e->getCode() . PHP_EOL;
});

$socket = new \React\Socket\Server('0.0.0.0:8080', $loop);
$server->listen($socket);

echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;

$loop->run();
