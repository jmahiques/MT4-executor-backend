<?php

namespace App\ValueObject;

use Webmozart\Assert\Assert;

final class Direction
{
    public const GREATER = 'greater';
    public const LESS = 'less';

    private $value;

    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    private function setValue(string $value)
    {
        $validValues = (new \ReflectionClass(__CLASS__))->getConstants();
        Assert::true(
            in_array($value, $validValues),
            sprintf('The direction must be in [%s]', implode(',', $validValues))
        );
        $this->value = $value;
    }

    public function get()
    {
        return $this->value;
    }

    public static function GREATER()
    {
        return new Direction(Direction::GREATER);
    }

    public static function LESS()
    {
        return new Direction(Direction::LESS);
    }
}
