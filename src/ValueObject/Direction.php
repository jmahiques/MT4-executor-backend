<?php

namespace App\ValueObject;

final class Direction
{
    public const GREATER = 'greater';
    public const LESS = 'less';

    private $value;

    private function __construct(string $value)
    {
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
