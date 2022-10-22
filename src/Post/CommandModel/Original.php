<?php

declare(strict_types=1);

namespace Post\CommandModel;

// Supports [RQ-04]-[RQ-07].
final class Original implements Post
{
    public readonly PostType $type;
    public readonly Timestamp $createdAt;

    public function __construct (
        public readonly Ticket $ticket,
        public readonly Uuid $id,
        public readonly Text $text,
        Now $now
    ){
        $this->createdAt = $now->timestamp;
        $this->type = PostType::ORIGINAL;

        if(!$this->ticket->inBetween($this->createdAt)) {
            throw new \LogicException(ExceptionReference::INVALID_CREATED_AT->value);
        }
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getType(): PostType
    {
        return $this->type;
    }

    public function hasSyncedTicket(): bool
    {
        return $this->ticket->inBetween($this->createdAt);
    }
}
