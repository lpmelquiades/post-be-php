<?php

declare(strict_types=1);

namespace Post\CommandModel;

//Supports [RQ-11]. Now is required to get the next persistence ticket for a post.
final class Now
{
    public readonly Timestamp $timestamp;

    public function __construct(
    ) {
        $this->timestamp = Timestamp::now();
    }
}
