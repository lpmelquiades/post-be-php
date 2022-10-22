<?php

declare(strict_types=1);

namespace Post\CommandModel;

final class Repost implements Post
{
    public readonly PostType $type;

    public function __construct(
        public readonly PostType $targetPostType,
        public readonly Ticket $ticket,
        public readonly Uuid $id,
        public readonly Uuid $targetPostId,
        public readonly Timestamp $createdAt
    ){
        $this->type = PostType::REPOST;

        if (
            $targetPostType->value === PostType::REPOST->value
            || $this->id->value === $this->targetPostId->value
        ) {
            throw new \LogicException(ExceptionReference::REPOST_OF_REPOST->value);
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
