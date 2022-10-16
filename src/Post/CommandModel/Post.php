<?php

declare(strict_types=1);

namespace Post\CommandModel;

interface Post
{
    public function getCreatedAt(): Timestamp;

    public function getUserName(): Username;

    public function getType(): PostType;
}
