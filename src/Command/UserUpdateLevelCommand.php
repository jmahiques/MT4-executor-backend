<?php

namespace App\Command;

class UserUpdateLevelCommand
{
    private $magicNumber;
    private $ticket;
    private $stopPrice;
    private $partialStopPrice;
    private $profitPrice;
    private $partialProfitPrice;

    public function __construct(
        int $magicNumber,
        int $ticket,
        float $stopPrice,
        float $partialStopPrice,
        float $profitPrice,
        float $partialProfitPrice
    ) {
        $this->magicNumber = $magicNumber;
        $this->ticket = $ticket;
        $this->stopPrice = $stopPrice;
        $this->partialStopPrice = $partialStopPrice;
        $this->profitPrice = $profitPrice;
        $this->partialProfitPrice = $partialProfitPrice;
    }

    public function getMagicNumber(): int
    {
        return $this->magicNumber;
    }

    public function getTicket(): int
    {
        return $this->ticket;
    }

    public function getStopPrice(): float
    {
        return $this->stopPrice;
    }

    public function getPartialStopPrice(): float
    {
        return $this->partialStopPrice;
    }

    public function getProfitPrice(): float
    {
        return $this->profitPrice;
    }

    public function getPartialProfitPrice(): float
    {
        return $this->partialProfitPrice;
    }
}
