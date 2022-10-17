<?php

declare(strict_types=1);

namespace Post\CommandModel;

final class Repost
{
    public readonly PostType $type;

    public function __construct(
        public readonly Uuid $id,
        public readonly Uuid $originalPostId,
        public readonly UserName $userName,
        public readonly Timestamp $createdAt
    ){
        $this->type = PostType::REPOST;
    }
}
