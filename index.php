<?php

use App\Communication\CommunicationResponse;
use App\Storage\RedisStorage;
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

try {
    $app = new App\App('/index.php', new RedisStorage());
    $response = $app->run($serverRequest);
} catch(\Exception $e) {
    //@todo log it
    $response = CommunicationResponse::INVALID_REQUEST($e->getMessage());
}

(new SapiEmitter())->emit($response);
