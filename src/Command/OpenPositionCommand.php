<?php

namespace App\DTO;

class OpenPositionCommand
{
    /** @var int */
    private $magicNumber;
    /** @var int */
    private $ticket;
    /** @var float */
    private $openPrice;
    /** @var \DateTime */
    private $openTime;
    /** @var string */
    private $instrument;
    /** @var int */
    private $digits;
    /** @var float */
    private $lots;
    /** @var string */
    private $type;
    /** @var int */
    private $stop;
    /** @var int */
    private $partialStop;
    /** @var int */
    private $profit;
    /** @var int */
    private $partialProfit;

    public function __construct(
        int $magicNumber,
        int $ticket,
        float $openPrice,
        \DateTime $openTime,
        string $instrument,
        int $digits,
        float $lots,
        string $type,
        int $stop,
        int $partialStop,
        int $profit,
        int $partialProfit
    ) {
        $this->magicNumber = $magicNumber;
        $this->ticket = $ticket;
        $this->openPrice = $openPrice;
        $this->openTime = $openTime;
        $this->instrument = $instrument;
        $this->digits = $digits;
        $this->lots = $lots;
        $this->type = $type;
        $this->stop = $stop;
        $this->partialStop = $partialStop;
        $this->profit = $profit;
        $this->partialProfit = $partialProfit;
    }

    public function getMagicNumber(): int
    {
        return $this->magicNumber;
    }

    public function getTicket(): int
    {
        return $this->ticket;
    }

    public function getOpenPrice(): float
    {
        return $this->openPrice;
    }

    public function getOpenTime(): \DateTime
    {
        return $this->openTime;
    }

    public function getInstrument(): string
    {
        return $this->instrument;
    }

    public function getDigits(): int
    {
        return $this->digits;
    }

    public function getLots(): float
    {
        return $this->lots;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStop(): int
    {
        return $this->stop;
    }

    public function getPartialStop(): int
    {
        return $this->partialStop;
    }

    public function getProfit(): int
    {
        return $this->profit;
    }

    public function getPartialProfit(): int
    {
        return $this->partialProfit;
    }
}
