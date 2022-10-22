<?php

declare(strict_types=1);

namespace Post\CommandModel;


//Supports [RQ-08]
final class UserName
{

    const MAX_LEN = 14;
    const MIN_LEN = 6;

    public function __construct(
        public readonly string $value
    ){
        if (
            strlen($this->value) > static::MAX_LEN
        ) {
            throw new \LogicException('INVALID_TEXT');
        }

        if (
            strlen($this->value) < static::MIN_LEN
        ) {
            throw new \LogicException('INVALID_TEXT');
        }

        if (
            !ctype_alnum($this->value)
        ) {
            throw new \LogicException('INVALID_TEXT');
        }
    }
}