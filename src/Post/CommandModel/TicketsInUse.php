<?php

declare(strict_types=1);

namespace Post\CommandModel;

use DateTime;
use Illuminate\Support\Collection;

final class TicketsInUse
{
    private Collection $coll;
    public readonly Timestamp $begin;
    public readonly Timestamp $end;

    public function __construct(
        public readonly UserName $userName,
        public readonly Now $now
    ){
        $this->begin = $now->timestamp->beginningOfDay();
        $this->end = $now->timestamp->beginningOfTomorrow();

        $this->coll = new Collection();
        
        $beginDT = DateTime::createFromFormat(Timestamp::FORMAT, $this->begin->value);
        $endDT = DateTime::createFromFormat(Timestamp::FORMAT, $this->end->value);
        if ($beginDT > $endDT) {
            throw new \LogicException(ExceptionReference::INVALID_CHRONOLOGY->value);
        }
    }

    public function add(Ticket $t): void
    {
        if ($this->coll->count() === Ticket::MAX_TICKET_NUMBER) {
            throw new \LogicException(ExceptionReference::POST_LIMIT_REACHED->value);
        }

        if (
            $t->begin->value !== $this->begin->value
            || $t->end->value !== $this->end->value
            || $t->userName->value !== $this->userName->value
        ) {
            throw new \LogicException(ExceptionReference::INVALID_TICKET->value);
        }
        $this->coll->put($t->value, $t);
    }

    public function next(): Ticket
    {
        if ($this->coll->count() === Ticket::MAX_TICKET_NUMBER) {
            throw new \LogicException(ExceptionReference::POST_LIMIT_REACHED->value);
        }

        $i = 1;
        while ($i < Ticket::MAX_TICKET_NUMBER && $this->coll->has($i)) {
            $i++;
        }

        return new Ticket(
            $this->userName,
            $this->begin,
            $this->end,
            $i
        );
    }
}
