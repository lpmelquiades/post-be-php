<?php

declare(strict_types=1);

namespace Post\Integration;

use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Original;
use Post\CommandModel\Post;
use Post\CommandModel\PostType;
use Post\CommandModel\Quote;
use Post\CommandModel\Repost;

final class PostDbFormat
{
    public function post(Post $post): array {

        return match($post->getType()->value) {
            PostType::ORIGINAL->value => $this->original($post),
            PostType::QUOTE->value => $this->quote($post),
            PostType::REPOST->value => $this->repost($post),
            'default' => throw new \LogicException(ExceptionReference::INVALID_POST_TYPE->value)
        };
    }

    public function quote(Quote $quote): array
    {
        return [
            'type' => $quote->type->value,
            'id' => $quote->id->value,
            'target_id' => $quote->targetPostId->value,
            'text' => $quote->text->value,
            'created_at' => $quote->createdAt->value,
            'user_name' => $quote->ticket->userName->value,
            'ticket_begin' => $quote->ticket->begin->value,
            'ticket_end' => $quote->ticket->end->value,
            'ticket_count' => $quote->ticket->value,
        ];
    }

    public function repost(Repost $repost): array
    {
        return [
            'type' => $repost->type->value,
            'id' => $repost->id->value,
            'target_id' => $repost->targetPostId->value,
            'created_at' => $repost->createdAt->value,
            'user_name' => $repost->ticket->userName->value,
            'ticket_begin' => $repost->ticket->begin->value,
            'ticket_end' => $repost->ticket->end->value,
            'ticket_count' => $repost->ticket->value,
        ];
    }

    public function original(Original $original): array
    {
        return [
            'type' => $original->type->value,
            'id' => $original->id->value,
            'text' => $original->text->value,
            'created_at' => $original->createdAt->value,
            'user_name' => $original->ticket->userName->value,
            'ticket_begin' => $original->ticket->begin->value,
            'ticket_end' => $original->ticket->end->value,
            'ticket_count' => $original->ticket->value,
        ];
    }
}