<?php

namespace App\Strategy;

use App\Entity\Position;

interface StrategyInterface
{
    public function apply(Position $position);
}
