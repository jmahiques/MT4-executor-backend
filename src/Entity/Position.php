<?php

namespace App\Entity;

use App\BusinessRule\BusinessRule;
use App\BusinessRule\GreaterThanRule;
use App\BusinessRule\LessThanRule;
use App\ValueObject\Direction;
use App\ValueObject\Level;
use App\ValueObject\Price;
use Webmozart\Assert\Assert;

final class Position
{
    const TYPE_BUY = 'buy';
    const TYPE_SELL = 'sell';

    const STATE_OPEN = 'open';
    const STATE_CLOSED_HALF = 'open';
    const STATE_HALF_BREAKEVEN = 'half.breakeven';
    const STATE_BREAKEVEN = 'breakeven';
    const STATE_CLOSED = 'closed';

    /** @var \DateTime */
    private $openTime;
    /** @var float */
    private $openPrice;
    /** @var Level */
    private $stop;
    /** @var Level */
    private $partialStop;
    /** @var Level */
    private $profit;
    /** @var Level */
    private $partialProfit;
    /** @var float */
    private $openLots;
    /** @var float */
    private $lots;
    /** @var string */
    private $instrument;
    /** @var int */
    private $ticket;
    /** @var int */
    private $digits;
    /** @var string */
    private $type;
    /** @var \DateTime */
    private $closedTime;
    /** @var \DateTime */
    private $closedHalfTime;
    /** @var string */
    private $currentState;
    /** @var int */
    private $magicNumber;

    private function __construct(
        string $type,
        int $magicNumber,
        int $ticket,
        \DateTime $openTime,
        float $openPrice,
        float $lots,
        float $digits,
        string $instrument,
        Level $stop,
        Level $partialStop,
        Level $profit,
        Level $partialProfit,
        array $rules
    ) {
        Assert::greaterThan($lots, 0, 'Lots should be greater than 0');
        Assert::greaterThan($digits, 0, 'Digits should be greater than 0');
        Assert::greaterThan($ticket, 0, 'Ticket should be greater than 0');

        $this->type = $type;
        $this->setOpenTime($openTime);
        $this->currentState = self::STATE_OPEN;
        $this->openPrice = $openPrice;
        $this->lots = $lots;
        $this->openLots = $lots;
        $this->digits = $digits;
        $this->instrument = $instrument;
        $this->ticket = $ticket;
        $this->magicNumber = $magicNumber;
        $this->stop = $stop;
        $this->partialStop = $partialStop;
        $this->profit = $profit;
        $this->partialProfit = $partialProfit;

        $this->validatePriceLevels($rules);
    }

    public static function BUY (
        int $magicNumber,
        int $ticket,
        \DateTime $openTime,
        float $openPrice,
        float $lots,
        float $digits,
        string $instrument,
        Level $stop,
        Level $partialStop,
        Level $profit,
        Level $partialProfit
    ) {
        $openPriceLevel = self::getOpenPriceLevel($openPrice, Direction::GREATER());

        return new Position(
            self::TYPE_BUY,
            $magicNumber,
            $ticket,
            $openTime,
            $openPrice,
            $lots,
            $digits,
            $instrument,
            $stop,
            $partialStop,
            $profit,
            $partialProfit,
            [
                // stop < partial_stop < open_price < partial_profit < profit
                new LessThanRule($stop, $partialStop, new \Exception('The stop must be less than the partial stop')),
                new LessThanRule($partialStop, $openPriceLevel, new \Exception('The partial stop must be less than the open price')),
                new LessThanRule($openPriceLevel, $partialProfit, new \Exception('The open price must be less than the partial profit')),
                new LessThanRule($partialProfit, $profit, new \Exception('The partial profit must be less than the profit')),
            ]
        );
    }

    public static function SELL(
        int $magicNumber,
        int $ticket,
        \DateTime $openTime,
        float $openPrice,
        float $lots,
        float $digits,
        string $instrument,
        Level $stop,
        Level $partialStop,
        Level $profit,
        Level $partialProfit
    ){
        $openPriceLevel = self::getOpenPriceLevel($openPrice, Direction::LESS());

        return new Position(
            self::TYPE_SELL,
            $magicNumber,
            $ticket,
            $openTime,
            $openPrice,
            $lots,
            $digits,
            $instrument,
            $stop,
            $partialStop,
            $profit,
            $partialProfit,
            [
                //stop > partial_stop > open_price > partial_profit > profit
                new GreaterThanRule($stop, $partialStop, new \Exception('The stop must be greater than the partial stop')),
                new GreaterThanRule($partialStop, $openPriceLevel, new \Exception('The partial stop must be greater than the open price')),
                new GreaterThanRule($openPriceLevel, $partialProfit, new \Exception('The open price must be greater than the partial profit')),
                new GreaterThanRule($partialProfit, $profit, new \Exception('The partial profit must be greater than the profit')),
            ]
        );
    }

    private function setOpenTime(\DateTime $openTime)
    {
        if ($openTime > new \DateTime('now')) {
            throw new \Exception('The open time cannot me higher than now');
        }

        $this->openTime = $openTime;
    }

    /**
     * @param BusinessRule[] $rules
     * @throws \Exception
     */
    private function validatePriceLevels(array $rules)
    {
        foreach ($rules as $rule) {
            $rule->validate();
        }
    }

    private static function getOpenPriceLevel(float $openPrice, Direction $direction)
    {
        Assert::greaterThan($openPrice, 0, 'The open price should be greater than 0');
        return new Level(new Price($openPrice), $direction);
    }

    public function reachedPartialStop(float $price)
    {
        return $this->partialStop->hasReachedPrice() ?: $this->partialStop->reached($price);
    }

    public function reachedStop(float $price)
    {
        return $this->stop->hasReachedPrice() ?: $this->stop->reached($price);
    }

    public function reachedPartialProfit(float $price)
    {
        return $this->partialProfit->hasReachedPrice() ?: $this->partialProfit->reached($price);
    }

    public function reachedProfit(float $price)
    {
        return $this->profit->hasReachedPrice() ?: $this->profit->reached($price);
    }

    public function magicNumber()
    {
        return $this->magicNumber;
    }

    public function ticket()
    {
        return $this->ticket;
    }
}
