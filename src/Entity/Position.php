<?php

namespace App\Entity;

final class Position
{
    const TYPE_BUY = 'buy';
    const TYPE_SELL = 'sell';

    const STATE_OPEN = 'open';
    const STATE_CLOSED_HALF = 'open';
    const STATE_HALF_BREAKEVEN = 'half.breakeven';
    const STATE_BREAKEVEN = 'breakeven';
    const STATE_CLOSED = 'closed';

    public $openTime;
    public $openPrice;
    public $stop;
    public $profit;
    public $partialProfit;
    public $partialStop;
    public $partialStopBreakEven;
    public $stopBreakEven;
    public $openLots;
    public $lots;
    public $instrument;
    public $ticket;
    public $digits;
    public $type;
    public $closedTime;
    public $closedHalfTime;
    public $currentState;

    public static function BUY (
        ?\DateTime $openTime = null,
        ?float $openPrice = null,
        ?float $lots = null,
        ?float $openLots = null,
        ?float $digits = null,
        ?string $instrument = null,
        ?float $ticket = null,
        ?float $stop = null,
        ?float $partialStop = null,
        ?float $profit = null,
        ?float $partialProfit = null,
        ?bool $partialStopBreakEven = false,
        ?bool $stopBreakEven = false,
        ?\DateTime $closedTime = null,
        ?\DateTime $closedHalfTime = null,
        ?string $currentState = self::STATE_OPEN
    ) {
        $self = new self();
        $self->type = self::TYPE_BUY;
        $self->openTime = $openTime;
        $self->openPrice = $openPrice;
        $self->stop = $stop;
        $self->profit = $profit;
        $self->partialProfit = $partialProfit;
        $self->partialStop = $partialStop;
        $self->partialStopBreakEven = $partialStopBreakEven;
        $self->stopBreakEven = $stopBreakEven;
        $self->openLots = $openLots;
        $self->lots = $lots;
        $self->instrument = $instrument;
        $self->ticket = $ticket;
        $self->digits = $digits;
        $self->closedTime = $closedTime;
        $self->closedHalfTime = $closedHalfTime;
        $self->currentState = $currentState;
        return $self;
    }

    public static function SELL(
        ?\DateTime $openTime = null,
        ?float $openPrice = null,
        ?float $lots = null,
        ?float $openLots = null,
        ?float $digits = null,
        ?string $instrument = null,
        ?float $ticket = null,
        ?float $stop = null,
        ?float $partialStop = null,
        ?float $profit = null,
        ?float $partialProfit = null,
        ?bool $partialStopBreakEven = false,
        ?bool $stopBreakEven = false,
        ?\DateTime $closedTime = null,
        ?\DateTime $closedHalfTime = null,
        ?string $currentState = self::STATE_OPEN
    ){
        $self = new self();
        $self->type = self::TYPE_SELL;
        $self->openTime = $openTime;
        $self->openPrice = $openPrice;
        $self->stop = $stop;
        $self->profit = $profit;
        $self->partialProfit = $partialProfit;
        $self->partialStop = $partialStop;
        $self->partialStopBreakEven = $partialStopBreakEven;
        $self->stopBreakEven = $stopBreakEven;
        $self->openLots = $openLots;
        $self->lots = $lots;
        $self->instrument = $instrument;
        $self->ticket = $ticket;
        $self->digits = $digits;
        $self->closedTime = $closedTime;
        $self->closedHalfTime = $closedHalfTime;
        $self->currentState = $currentState;
        return $self;
    }
}
