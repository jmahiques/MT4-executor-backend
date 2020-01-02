<?php

namespace App\BusinessRule;

use App\ValueObject\Level;

class LessThanRule extends BusinessRule
{
    private $a;
    private $b;

    public function __construct(Level $a, Level $b, \Exception $exception)
    {
        $this->a = $a;
        $this->b = $b;
        $this->exception = $exception;
    }

    protected function violateRule()
    {
        if ($this->a->atPrice() < $this->b->atPrice()) {
            return false;
        }

        return true;
    }
}
