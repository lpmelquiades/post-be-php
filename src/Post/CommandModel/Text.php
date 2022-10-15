<?php

declare(strict_types=1);

namespace Post\CommandModel;

final class Text
{

    const MAX_LEN = 777;

    public function __construct(
        public readonly string $value
    ){
        if (strlen($this->value) > static::MAX_LEN) {
            throw new \LogicException('INVALID_TEXT');
        }
    }
}
