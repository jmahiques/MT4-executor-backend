<?php

use App\Router\Router;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

require_once __DIR__ . '/vendor/autoload.php';

$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory
);
$serverRequest = $creator->fromGlobals();

$response = (new Router('/index.php'))
    ->match($serverRequest->getUri()->getPath())
    ->execute($serverRequest);

(new SapiEmitter())->emit($response);
