<?php

namespace App\Storage;

interface StorageInterface
{
    public function set(string $key, object $object): void;

    public function get(string $key): ?object;
}
