<?php

namespace App\Storage;

class RedisStorage implements StorageInterface
{
    /** @var \Redis */
    private static $connection = null;

    public function __construct()
    {
        if (!static::$connection instanceof \Redis) {
            $connection = new \Redis();
            $connection->connect('redis');
            static::$connection = $connection;
        }
    }

    public function get(string $key): ?object
    {
        $serializedObject = static::$connection->get($key);

        return is_string($serializedObject)
            ? unserialize($serializedObject)
            : null;
    }

    public function set(string $key, object $object): void
    {
        static::$connection->set($key, serialize($object));
    }
}
