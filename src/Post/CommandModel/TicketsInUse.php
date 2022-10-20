<?php

declare(strict_types=1);

namespace Post\CommandModel;

use Illuminate\Support\Collection;

final class TicketsInUse
{
    private Collection $coll;

    public function __construct(
        public readonly UserName $userName,
        public readonly Timestamp $begin,
        public readonly Timestamp $end
    ){
        $this->coll = new Collection();
    }

    public function add(Ticket $t): void
    {
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
        if ($this->coll->count() > Ticket::MAX_TICKET_NUMBER) {
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
