<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\Original;

final class OriginalHandler
{
    public function __construct(private LoadPort $load)
    {
    }

    public function handler(Original $original): void
    {
        $segment = $this->load->segment(
            $original->userName,
            $original->createdAt->beginningOfDay(),
            $original->createdAt->beginningOfTomorrow()
        );

        $segment->post($original);
    }
}
