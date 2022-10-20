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

    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'id' => $this->id->value,
            'target_id' => $this->targetPostId->value,
            'created_at' => $this->createdAt->value,
            'user_name' => $this->ticket->userName->value,
            'ticket_begin' => $this->ticket->begin->value,
            'ticket_end' => $this->ticket->end->value,
            'ticket_count' => $this->ticket->value,
        ];
    }
}
