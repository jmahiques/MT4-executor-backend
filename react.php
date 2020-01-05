<?php

use App\Utils\Server;

require_once __DIR__ . '/vendor/autoload.php';

$redis = new Redis();
$redis->connect('redis');

Server::initialize();
