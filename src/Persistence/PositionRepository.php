<?php

namespace App\Persistence;

use App\Entity\Position;

class PositionRepository
{
    private $redis;

    public function __construct()
    {
        $this->redis = RedisConnection::getConnection();
    }

    public function save(Position $position)
    {
        $this->redis->set(
            $this->generateKey($position->magicNumber(), $position->ticket()),
            serialize($position)
        );
    }

    public function get(int $magicNumber, int $ticket): ?Position
    {
        $position = $this->redis->get($this->generateKey($magicNumber, $ticket));
        if ($position !== null) {
            return unserialize($position);
        }

        return null;
    }

    private function generateKey(int $magicNumber, int $ticket)
    {
        return sprintf('%s-%s', $magicNumber, $ticket);
    }
}
