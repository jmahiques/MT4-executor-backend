<?php

namespace App\Strategy;

use App\Entity\Position;

final class DefaultStrategy implements StrategyInterface
{
    private $stopLoss;
    private $partialStopLoss;
    private $partialTakeProfit;
    private $takeProfit;
    private $lots;
    private $digitsOffset;

    public function __construct(
        int $stopLoss,
        int $partialStopLoss,
        int $partialTakeProfit,
        int $takeProfit,
        float $lots,
        int $digitsOffset = 1
    ) {
        $this->stopLoss = $stopLoss;
        $this->partialStopLoss = $partialStopLoss;
        $this->partialTakeProfit = $partialTakeProfit;
        $this->takeProfit = $takeProfit;
        $this->lots = $lots;
        $this->digitsOffset = $digitsOffset;
    }

    public function apply(Position $position)
    {
        if ($position->type === Position::TYPE_BUY) {
            return $this->computeBuy($position);
        } elseif ($position->type === Position::TYPE_SELL) {
            return $this->computeSell($position);
        }

        throw new \Exception(sprintf('Unknown position type "%s"', $position->type));
    }

    private function computeBuy(Position $position)
    {
        $position->stop = $position->openPrice - $this->normalizePips($position->digits, $this->stopLoss);
        $position->partialStop = $position->openPrice - $this->normalizePips($position->digits, $this->partialStopLoss);
        $position->profit = $position->openPrice + $this->normalizePips($position->digits, $this->takeProfit);
        $position->partialProfit = $position->openPrice + $this->normalizePips($position->digits, $this->partialTakeProfit);
        $position->lots = $this->lots;
        $position->openLots = $this->lots;

        return $position;
    }

    private function computeSell(Position $position)
    {
        $position->stop = $position->openPrice + $this->normalizePips($position->digits, $this->stopLoss);
        $position->partialStop = $position->openPrice + $this->normalizePips($position->digits, $this->partialStopLoss);
        $position->profit = $position->openPrice - $this->normalizePips($position->digits, $this->takeProfit);
        $position->partialProfit = $position->openPrice - $this->normalizePips($position->digits, $this->partialTakeProfit);
        $position->lots = $this->lots;
        $position->openLots = $this->lots;

        return $position;
    }

    private function normalizePips(int $digits, int $pips)
    {
        $normalizedPips = $pips/pow(10, $digits-$this->digitsOffset);
        return (float)number_format($normalizedPips, $pips);
    }
}
