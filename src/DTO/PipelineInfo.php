<?php

namespace App\DTO;

class PipelineInfo
{
    /** @var array */
    public $payload;

    public $dto;

    public function __construct(array $payload, $dto)
    {
        $this->payload = $payload;
        $this->dto = $dto;
    }
}
