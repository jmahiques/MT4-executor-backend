<?php

namespace App\ValueObject;

use Webmozart\Assert\Assert;

final class Level
{
    private $price;
    private $reached;
    private $direction;
    private $reachedAt;

    public function __construct(Price $price, Direction $direction)
    {
        $this->price = $price;
        $this->direction = $direction;
        $this->reached = false;
    }

    private function priceReachedLevelPrice()
    {
        $this->reached = true;
        $this->reachedAt = new \DateTime('now');
    }

    public function reached(float $price): bool
    {
        Assert::notEq($this->reached, true, 'The price was reached the level previously');

        if ($this->direction->get() === Direction::LESS && $this->price->get() >= $price) {
            $this->priceReachedLevelPrice();
            return true;
        } elseif ($this->direction->get() === Direction::GREATER && $this->price->get() <= $price) {
            $this->priceReachedLevelPrice();
            return true;
        }

        return false;
    }

    public function hasReachedPrice(): bool
    {
        return $this->reached;
    }

    public function atPrice(): float
    {
        return $this->price->get();
    }

    public function when(): ?\DateTime
    {
        return $this->reachedAt;
    }

    public function direction(): string
    {
        return $this->direction->get();
    }
}
