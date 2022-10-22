<?php

declare(strict_types=1);

namespace Post\CommandModel;

final class NextPost
{
    public function __construct(
        TicketsInUse $inUse,
        public readonly Post $post
    ) {
        if (
            $inUse->begin->value !== $this->post->getTicket()->begin->value
            || $inUse->end->value !== $this->post->getTicket()->end->value
            || !$this->post->hasSyncedTicket()
        ) {
            throw new \LogicException(ExceptionReference::INVALID_TICKET->value);
        }
    }
}
