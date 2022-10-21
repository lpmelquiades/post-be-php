<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Text;
use Post\CommandModel\UserName;

final class PostCommand
{
    public function __construct (
        public readonly UserName $userName,
        public readonly Text $text
    ){
    }

    public static function build(string $payload): static
    {
        $arr = json_decode($payload, true);
        if (!isset($arr['username']) || !isset($arr['text'])) {
            throw new \LogicException(ExceptionReference::INVALID_JSON_SCHEMA->value);
        }

        return new static(
            new UserName($arr['username']),
            new Text($arr['text'])     
        );
    }
}
