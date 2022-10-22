<?php

declare(strict_types=1);

namespace Post\QueryModel;

final class Uuid
{
    public function __construct(
        public readonly string $value
    ) {
        preg_match('/[0-9a-fA-F]{32}/', $this->value, $matched);
        if (!isset($matched[0]) || $matched[0] !== $this->value){
            throw new \LogicException(ExceptionReference::INVALID_UUID->value);
        }
    }

    public static function build(): static
    {
        return new static(str_replace('-','', \Ramsey\Uuid\Uuid::uuid4()->toString()));
    }
}
