<?php

declare(strict_types=1);

namespace Post\CommandModel;

interface Post
{
    public function toArray(): array;
}
