<?php

namespace App\Storage;

use App\Entity\Position;

class PositionRepository
{
    /** @var StorageInterface */
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function save(Position $position)
    {
        $this->storage->set(
            $this->generateKey($position->magicNumber(), $position->ticket()),
            $position
        );
    }

    public function get(int $magicNumber, int $ticket): ?Position
    {
        return $this->storage->get(
            $this->generateKey($magicNumber, $ticket)
        );
    }

    private function generateKey(int $magicNumber, int $ticket)
    {
        return sprintf('%s-%s', $magicNumber, $ticket);
    }
}
