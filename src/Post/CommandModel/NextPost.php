<?php

declare(strict_types=1);

namespace Post\CommandModel;


/** Supports [RQ-11]
 * NexPost is needed to persist a new Post
 * */
final class NextPost
{
    public function __construct(
        TicketsInUse $inUse,
        public readonly Post $post
    ) {
        if ($inUse->begin->value !== $this->post->getTicket()->begin->value) {
            throw new \LogicException(ExceptionReference::INVALID_TICKET->value);
        }

        if ($inUse->end->value !== $this->post->getTicket()->end->value) {
            throw new \LogicException(ExceptionReference::INVALID_TICKET->value);
        }

        if (!$this->post->hasSyncedTicket()) {
            throw new \LogicException(ExceptionReference::INVALID_TICKET->value);
        }
    }
}
