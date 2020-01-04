<?php

namespace App\PipelineStage;

final class MapStringStage extends MapValueStage
{
    protected function assertValue($value)
    {
        return;
    }

    protected function parseValue($value)
    {
        return $value;
    }
}
