<?php

namespace App\Persistence;

class RedisConnection
{
    private static $connection = null;

    public static function getConnection(): \Redis
    {
        if (!static::$connection instanceof \Redis) {
            $connection = new \Redis();
            $connection->connect('redis');
            static::$connection = $connection;
        }

        return static::$connection;
    }
}
