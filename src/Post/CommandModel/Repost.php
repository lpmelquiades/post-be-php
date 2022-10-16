<?php

declare(strict_types=1);

namespace Post\CommandModel;

final class Repost implements Post
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

    public function getCreatedAt(): Timestamp
    {
        return $this->createdAt;
    }

    public function getUserName(): UserName
    {
        return $this->userName;
    }

    public function getType(): PostType
    {
        return $this->type;
    }
}
