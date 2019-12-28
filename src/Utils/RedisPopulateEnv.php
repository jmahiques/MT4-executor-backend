<?php

namespace App\Utils;

use App\Persistence\RedisConnection;

final class RedisPopulateEnv
{
    public static function populate(array $envs)
    {
        $connection = RedisConnection::getConnection();
        foreach ($envs as $key => $value) {
            $connection->set($key, $value);
        }
    }
}
