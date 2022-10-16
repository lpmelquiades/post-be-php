<?php

declare(strict_types=1);

namespace Post\CommandModel;

use DateTime;
use Post\CommandModel\ExceptionReference;

final class Timestamp
{
    const FORMAT = "Y-m-d\TH:i:s.u\Z";

    public function __construct(
        public readonly string $value
    ) {
        if (DateTime::createFromFormat(static::FORMAT, $this->value) === false) {
            throw new \LogicException(ExceptionReference::INVALID_TIMESTAMP->value);
        }
    }
    
    public static function now(): static
    {
        $date = new DateTime( "NOW" );
        return new static($date->format(static::FORMAT));
    }

    public function beginningOfDay(): static
    {
        $date = DateTime::createFromFormat(static::FORMAT, $this->value);
        $date->setTime(0, 0, 0, 0);
        return new static($date->format( "Y-m-d\TH:i:s.u\Z" ));
    }

    public function beginningOfTomorrow(): static
    {
        $date = DateTime::createFromFormat(static::FORMAT, $this->value);
        $date->modify('+1 day');
        $date->setTime(0, 0, 0, 0);
        return new static($date->format( "Y-m-d\TH:i:s.u\Z" ));
    }
}
