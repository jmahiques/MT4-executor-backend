<?php

namespace App\Command;

class TickCommand
{
    /** @var int */
    private $magicNumber;
    /** @var int */
    private $ticket;
    /** @var float */
    private $bid;
    /** @var float */
    private $ask;

    public function __construct(int $magicNumber, int $ticket, float $bid, float $ask)
    {
        $this->magicNumber = $magicNumber;
        $this->ticket = $ticket;
        $this->bid = $bid;
        $this->ask = $ask;
    }

    public function getMagicNumber(): int
    {
        return $this->magicNumber;
    }

    public function getTicket(): int
    {
        return $this->ticket;
    }

    public function getBid(): float
    {
        return $this->bid;
    }

    public function getAsk(): float
    {
        return $this->ask;
    }
}
