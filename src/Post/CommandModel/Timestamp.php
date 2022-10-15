<?php

declare(strict_types=1);

namespace Post\CommandModel;

use DateTime;
use Post\CommandModel\ExceptionReference;

final class Timestamp
{
    public function __construct(
        public readonly string $value
    ) {
        if (DateTime::createFromFormat("Y-m-d\TH:i:s.u\Z", $this->value) === false) {
            throw new \LogicException(ExceptionReference::INVALID_TIMESTAMP->value);
        }
    }
    
    public static function now(): static
    {
        $date = new DateTime( "NOW" );
        return new static($date->format( "Y-m-d\TH:i:s.u\Z" ));
    }
}
