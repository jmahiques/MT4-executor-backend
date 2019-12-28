<?php

use App\Utils\RedisPopulateEnv;
use App\Utils\Server;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';
$envFilepath = __DIR__.'/.env.local';

$redis = new Redis();
$redis->connect('redis');

if (!@file_exists($envFilepath)) {
    throw new \Exception(sprintf('%s file not found', $envFilepath));
}

(new Dotenv(false))->load($envFilepath);
RedisPopulateEnv::populate($_ENV);

Server::initialize();