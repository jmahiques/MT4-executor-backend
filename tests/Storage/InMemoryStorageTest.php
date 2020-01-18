<?php

use App\Storage\InMemoryStorage;
use App\Storage\RedisStorage;
use PHPUnit\Framework\TestCase;

class InMemoryStorageTest extends TestCase
{
    //Refresh the content of the value un Redis service
    protected function setUp(): void
    {
        $redis = new \Redis();
        $redis->connect('redis');
        $redis->del('STORAGE_IN_MEMORY_STATE');
    }

    public function testFlush()
    {
        $storage = new InMemoryStorage();
        $storage->set('value1', 1);
        $storage->set('value2', 2);

        $storage->flush();

        $redisStorage = new RedisStorage();
        self::assertEquals($redisStorage->get('STORAGE_IN_MEMORY_STATE'), ['value1'=>1, 'value2'=>2]);
    }

    public function testInitialize()
    {
        $redisStorage = new RedisStorage();
        $redisStorage->set('STORAGE_IN_MEMORY_STATE', ['1-1' => 1, '1-2' => 2]);

        $storage = new InMemoryStorage();
        self::assertEquals(1, $storage->get('1-1'));
        self::assertEquals(2, $storage->get('1-2'));
    }

    public function tesCreateWithStorage()
    {
        $inMemoryStorageMock = $this->createMock(InMemoryStorage::class);
        $inMemoryStorageMock->expects($this->once())
            ->method('get')
            ->willReturn(['1-1' => 1, '1-2' => 2]);

        $storage = new InMemoryStorage($inMemoryStorageMock);
        self::assertEquals(1, $storage->get('1-1'));
        self::assertEquals(2, $storage->get('1-2'));
    }
}
