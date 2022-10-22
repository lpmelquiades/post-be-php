<?php

declare(strict_types=1);

namespace Post\CommandModel;

use DateTime;

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

        $beginDT = DateTime::createFromFormat(Timestamp::FORMAT, $this->begin->value);
        $endDT = DateTime::createFromFormat(Timestamp::FORMAT, $this->end->value);
        if ($beginDT > $endDT) {
            throw new \LogicException(ExceptionReference::INVALID_CHRONOLOGY->value);
        }

    }
    
    public function inBetween(Timestamp $at): bool
    {
        $createdAtDT = DateTime::createFromFormat(
            Timestamp::FORMAT,
            $at->value
        );
        $beginDT = DateTime::createFromFormat(Timestamp::FORMAT, $this->begin->value);
        $endDT = DateTime::createFromFormat(Timestamp::FORMAT, $this->end->value);
        if ($createdAtDT < $beginDT || $createdAtDT >= $endDT) {
            return false;
        }
        return true;
    }
}
