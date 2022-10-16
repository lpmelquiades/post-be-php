<?php

declare(strict_types=1);

namespace Post\CommandModel;

final class PostFactory
{
    public function build(string $data, PostType $type): Post
    {
        $payload = json_decode($data, true);
        // fwrite(STDOUT, var_export($payload, true));
        return match($type->value) {
            PostType::ORIGINAL->value => $this->original($payload),
            PostType::REPOST->value => $this->repost($payload),
            PostType::QUOTE->value => $this->quote($payload),
            'default' => throw new \LogicException(ExceptionReference::INVALID_POST->value)
        };
    }

    public function original(array $payload): Original
    {
        if (!isset($payload['username']) || !isset($payload['text'])) {
            throw new \LogicException(ExceptionReference::INVALID_ORIGINAL->value);
        }

        return new Original(
            Uuid::build(),
            new UserName($payload['username']),
            new Text($payload['text']),
            Timestamp::now()
        );
    }

    public function repost(array $payload): Repost
    {
        if (!isset($payload['username']) || !isset($payload['original_id'])) {
            throw new \LogicException(ExceptionReference::INVALID_REPOST->value);
        }

        return new Repost(
            Uuid::build(),
            new Uuid($payload['original_id']),
            new UserName($payload['username']),
            Timestamp::now()
        );
    }

    public function quote(array $payload): Quote
    {

        if (
            !isset($payload['username'])
            || !isset($payload['text'])
            || !isset($payload['original_id'])
        ) {
            throw new \LogicException(ExceptionReference::INVALID_QUOTE->value);
        }

        return new Quote(
            Uuid::build(),
            new Uuid($payload['original_id']),
            new UserName($payload['username']),
            new Text($payload['text']),
            Timestamp::now()
        );
    }
}
