<?php

declare(strict_types=1);

namespace Post\CommandModel;
final class Original implements Post
{
    public readonly PostType $type;

    public function __construct (
        public readonly Ticket $ticket,
        public readonly Uuid $id,
        public readonly Text $text,
        public readonly Timestamp $createdAt,
    ){
        $this->type = PostType::ORIGINAL;

        if(!$this->ticket->inBetween($this->createdAt)) {
            throw new \LogicException(ExceptionReference::INVALID_CREATED_AT->value);
        }
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'id' => $this->id->value,
            'text' => $this->text->value,
            'created_at' => $this->createdAt->value,
            'user_name' => $this->ticket->userName->value,
            'ticket_begin' => $this->ticket->begin->value,
            'ticket_end' => $this->ticket->end->value,
            'ticket_count' => $this->ticket->value,
        ];
    }
}
