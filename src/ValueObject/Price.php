<?php

namespace App\ValueObject;

use Webmozart\Assert\Assert;

final class Price
{
    private $value;

    public function __construct(float $value)
    {
        Assert::greaterThan($value, 0.00, sprintf('Incorrect value %s, should be greater than 0', $value));
        $this->value = $value;
    }

    public function get()
    {
        return $this->value;
    }
}
