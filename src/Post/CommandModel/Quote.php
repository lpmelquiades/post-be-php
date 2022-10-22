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
}
