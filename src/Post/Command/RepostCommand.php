<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Timestamp;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;

final class RepostCommand
{
    public function __construct(
        public readonly Uuid $targetPostId,
        public readonly UserName $userName
    ){
    }

    public static function build(string $payload): static
    {
        $arr = json_decode($payload, true);
        if (!isset($arr['username']) || !isset($arr['target_id'])) {
            throw new \LogicException(ExceptionReference::INVALID_JSON_SCHEMA->value);
        }

        return new static(
            new Uuid($arr['target_id']),
            new UserName($arr['username']),
            Timestamp::now()
        );
    }
}
