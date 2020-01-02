<?php

namespace App\ValueObject;

final class Price
{
    private $value;

    public function __construct(float $value)
    {
        if ($value <= 0) {
            throw new \Exception(sprintf('Incorrect value %s should be greater than 0.', $value));
        }

        $this->value = $value;
    }

    public function get()
    {
        return $this->value;
    }
}
