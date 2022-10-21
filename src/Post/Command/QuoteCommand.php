<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Text;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;

final class QuoteCommand
{
    public function __construct(
        public readonly Uuid $targetPostId,
        public readonly UserName $userName,
        public readonly Text $text
    ){
    }

    public static function build(string $payload): static
    {
        $arr = json_decode($payload, true);
        if (
            !isset($arr['username'])
            || !isset($arr['text'])
            || !isset($arr['target_id'])
        ) {
            throw new \LogicException(ExceptionReference::INVALID_JSON_SCHEMA->value);
        }

        return new static(
            new Uuid($arr['target_id']),
            new UserName($arr['username']),
            new Text($arr['text'])
        );
    }
}
