<?php

namespace App\Utils;

use App\EndPoint\Probe;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server as ReactPHPServer;
use App\EndPoint\OpenPosition;
use App\EndPoint\MarketTick;

final class Server
{
    public static function initialize()
    {
        $loop = Factory::create();
        $server = new ReactPHPServer(function (ServerRequestInterface $request) {

            if ($request->getUri()->getPath() === '/open') {
                return (new OpenPosition())->execute($request->getParsedBody());
            } elseif ($request->getUri()->getPath() === '/tick') {
                return (new MarketTick())->execute($request->getParsedBody());
            } elseif ($request->getUri()->getPath() === '/probe') {
                return (new Probe())->execute($request->getParsedBody());
            }

            return new Response(404);
        });

        $server->on('error', function (\Throwable $e) {
            echo 'Error: ' . $e->getMessage() . ' --' . $e->getTraceAsString() . PHP_EOL;
            echo 'File: '.$e->getFile().' Line: '.$e->getLine().' Code: '.$e->getCode() . PHP_EOL;
        });

        $socket = new \React\Socket\Server('0.0.0.0:8080', $loop);
        $server->listen($socket);

        echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;

        $loop->run();
    }
}
