<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\Timestamp;
use Post\CommandModel\Uuid;

final class QuoteHandler
{
    public function __construct(private LoadPort $load)
    {
    }

    public function handler(Quote $quote): void
    {
        $now = Timestamp::now();
        $segment = $this->load->segment(
            $quote->userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $original = $this->load->original($quote->originalPostId);
        $segment->quote($original, $quote->userName, $quote->text, $now);
    }
}
