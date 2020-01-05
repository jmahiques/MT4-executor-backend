<?php

namespace App\PipelineStage;

use App\Communication\RequestParam;
use League\Pipeline\StageInterface;
use Webmozart\Assert\Assert;

abstract class ValidateAndParseValueStage implements StageInterface
{
    protected $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param array $payload
     * @return array
     */
    public function __invoke($payload)
    {
        Assert::keyExists(
            $payload,
            $this->key,
            sprintf('The value for key %s must be sent', RequestParam::getNameForConstant($this->key))
        );

        $this->assertValue($payload[$this->key]);
        $payload[$this->key] = $this->parseValue($payload[$this->key]);

        return $payload;
    }

    protected abstract function assertValue($value);

    protected abstract function parseValue($value);
}
