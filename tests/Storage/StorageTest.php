<?php

use App\Storage\InMemoryStorage;
use App\Storage\RedisStorage;
use App\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class StorageTest extends TestCase
{
    /**
     * @dataProvider getStorages
     * @param StorageInterface $storage
     */
    public function testSetReturnsValidObject(StorageInterface $storage)
    {
        $storage->set('test', new \stdClass());

        $object = $storage->get('test');
        self::assertInstanceOf(\stdClass::class, $object);
    }

    /**
     * @dataProvider getStorages
     * @param StorageInterface $storage
     */
    public function testGetReturnsNull(StorageInterface $storage)
    {
        self::assertNull($storage->get('object'));
    }

    public function getStorages()
    {
        return [
            [new RedisStorage()],
            [new InMemoryStorage()],
        ];
    }
}
