<?php

use App\EndPoint\MarketTick;
use App\EndPoint\OpenPosition;
use App\EndPoint\Probe;
use App\Utils\RedisPopulateEnv;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use RingCentral\Psr7\Response;
use Symfony\Component\Dotenv\Dotenv;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

require_once __DIR__ . '/vendor/autoload.php';
$envFilepath = __DIR__.'/.env.local';

if (!@file_exists($envFilepath)) {
    throw new \Exception(sprintf('%s file not found', $envFilepath));
}

(new Dotenv(false))->load($envFilepath);
RedisPopulateEnv::populate($_ENV);

$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory
);
$serverRequest = $creator->fromGlobals();

$response = new Response(404);
if ($serverRequest->getUri()->getPath() === '/index.php/open') {
    $response = (new OpenPosition())->execute($serverRequest);
} elseif ($serverRequest->getUri()->getPath() === '/index.php/tick') {
    $response = (new MarketTick())->execute($serverRequest);
} elseif ($serverRequest->getUri()->getPath() === '/index.php/probe') {
    $response = (new Probe())->execute($serverRequest);
} elseif ($serverRequest->getUri()->getPath() === '/index.php/recreate') {
    $response = (new Probe())->execute($serverRequest);
}

(new SapiEmitter())->emit($response);