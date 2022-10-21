<?php

declare(strict_types=1);

namespace Post\QueryModel;

/**
 * Only alphanumeric characters can be used for username
 * Maximum 14 characters for username
 * Usernames should be unique values
 */

final class UserName
{

    const MAX_LEN = 14;
    const MIN_LEN = 6;

    public function __construct(
        public readonly string $value
    ){
        if (
            strlen($this->value) > static::MAX_LEN
            || strlen($this->value) <= static::MIN_LEN
            || !ctype_alnum($this->value)
        ) {
            throw new \LogicException('INVALID_TEXT');
        }
    }
}