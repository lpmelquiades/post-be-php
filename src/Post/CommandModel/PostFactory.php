<?php

declare(strict_types=1);

namespace Post\CommandModel;

final class PostFactory
{
    public function build(string $data, PostType $type): Post
    {
        $payload = json_decode($data, true);
        return match($type->value) {
            PostType::ORIGINAL->value => $this->original($payload),
            PostType::REPOST->value => $this->repost($payload),
            PostType::QUOTE->value => $this->quote($payload),
            'default' => throw new \LogicException(ExceptionReference::INVALID_POST->value)
        };
    }

    public function original($payload): Original
    {
        return new Original(
            Uuid::build(),
            new UserName($payload['username']),
            new Text($payload['text']),
            Timestamp::now()
        );
    }

    public function repost($payload): Repost
    {
        return new Repost(
            Uuid::build(),
            new Uuid($payload['original_id']),
            new UserName($payload['username']),
            Timestamp::now()
        );
    }

    public function quote($payload): Quote
    {
        return new Quote(
            Uuid::build(),
            new Uuid($payload['original_id']),
            new UserName($payload['username']),
            new Text($payload['text']),
            Timestamp::now()
        );
    }
}
