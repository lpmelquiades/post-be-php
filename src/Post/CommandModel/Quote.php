<?php

declare(strict_types=1);

namespace Post\CommandModel;

use LogicException;

final class Quote implements Post
{
    public readonly PostType $type;

    public function __construct(
        public readonly PostType $targetPostType,
        public readonly Ticket $ticket,
        public readonly Uuid $id,
        public readonly Uuid $targetPostId,
        public readonly Text $text,
        public readonly Timestamp $createdAt
    ){
        if ($targetPostType->value === PostType::QUOTE->value) {
            throw new LogicException(ExceptionReference::QUOTE_OF_QUOTE->value);
        }
        $this->type = PostType::QUOTE;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'id' => $this->id->value,
            'target_id' => $this->targetPostId->value,
            'text' => $this->text->value,
            'created_at' => $this->createdAt->value,
            'user_name' => $this->ticket->userName->value,
            'ticket_begin' => $this->ticket->begin->value,
            'ticket_end' => $this->ticket->end->value,
            'ticket_count' => $this->ticket->value,
        ];
    }
}
