<?php

namespace App\Storage;

class InMemoryStorage implements StorageInterface
{
    private $storage = [];

    public function get(string $key): ?object
    {
        return $this->storage[$key] ?? null;
    }

    public function set(string $key, object $object): void
    {
        $this->storage[$key] = $object;
    }
}
