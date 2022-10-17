<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Timestamp;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;

final class Repost
{
    public function __construct(
        public readonly Uuid $originalPostId,
        public readonly UserName $userName,
        public readonly Timestamp $createdAt
    ){
    }

    public static function build(string $payload): Repost
    {
        $arr = json_decode($payload, true);
        if (!isset($arr['username']) || !isset($arr['target_id'])) {
            throw new \LogicException(ExceptionReference::INVALID_REPOST->value);
        }

        return new static(
            new Uuid($arr['target_id']),
            new UserName($arr['username']),
            Timestamp::now()
        );
    }
}
