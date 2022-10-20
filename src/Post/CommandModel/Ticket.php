<?php

declare(strict_types=1);

namespace Post\CommandModel;

final class Ticket
{
    const MAX_TICKET_NUMBER = 5;

    public function __construct(
        public readonly UserName $userName,
        public readonly Timestamp $begin,
        public readonly Timestamp $end,
        public readonly int $value
    ){
        if ($this->value > static::MAX_TICKET_NUMBER) {
            throw new \LogicException(ExceptionReference::POST_LIMIT_REACHED->value);
        }

        if ($this->value < 1) {
            throw new \LogicException(ExceptionReference::INVALID_TICKET->value);
        }
    }
}
