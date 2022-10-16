<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Text;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;

final class Quote
{
    public function __construct(
        public readonly Uuid $originalPostId,
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
            || !isset($arr['original_id'])
        ) {
            throw new \LogicException(ExceptionReference::INVALID_QUOTE->value);
        }

        return new static(
            new Uuid($arr['original_id']),
            new UserName($arr['username']),
            new Text($arr['text'])
        );
    }
}