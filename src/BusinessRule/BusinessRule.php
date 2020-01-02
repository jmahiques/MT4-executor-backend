<?php

namespace App\BusinessRule;

abstract class BusinessRule
{
    protected $exception;

    protected abstract function violateRule();

    public function validate()
    {
        if ($this->violateRule()) {
            throw $this->exception;
        }
    }
}
