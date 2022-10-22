<?php

declare(strict_types=1);

namespace Post\CommandModel;

final class Now
{
    public readonly Timestamp $timestamp;

    public function __construct(
    ) {
        $this->timestamp = Timestamp::now();
    }
}
