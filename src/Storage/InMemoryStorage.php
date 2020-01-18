<?php

namespace App\Storage;

class InMemoryStorage implements StorageInterface, PersistentAwareInterface
{
    private const PERSISTENCE_KEY = 'STORAGE_IN_MEMORY_STATE';

    /** @var StorageInterface */
    private $persistenceStorage;
    private $storage = [];

    public function __construct(?StorageInterface $persistenceStorage = null)
    {
        $this->persistenceStorage = $persistenceStorage ?: new RedisStorage();
        $this->initialize();
    }

    public function get(string $key)
    {
        return $this->storage[$key] ?? null;
    }

    public function set(string $key, $object): void
    {
        $this->storage[$key] = $object;
    }

    public function flush(): void
    {
        $this->persistenceStorage->set(self::PERSISTENCE_KEY, $this->storage);
    }

    private function initialize(): void
    {
        $this->storage = $this->persistenceStorage->get(self::PERSISTENCE_KEY);
    }
}
