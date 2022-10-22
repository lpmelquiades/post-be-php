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
}
