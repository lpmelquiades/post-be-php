<?php

declare(strict_types=1);

namespace Post\CommandModel;

use LogicException;

final class Quote implements Post
{
    public readonly PostType $type;
    public readonly Timestamp $createdAt;

    public function __construct(
        public readonly PostType $targetPostType,
        public readonly Ticket $ticket,
        public readonly Uuid $id,
        public readonly Uuid $targetPostId,
        public readonly Text $text,
        Now $now
    ){
        $this->createdAt = $now->timestamp;
        $this->type = PostType::QUOTE;
        
        if (
            $targetPostType->value === PostType::QUOTE->value
            || $this->id->value === $this->targetPostId->value
        ) {
            throw new LogicException(ExceptionReference::QUOTE_OF_QUOTE->value);
        }

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
