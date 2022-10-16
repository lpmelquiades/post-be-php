<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\Post;
use Post\CommandModel\Quote;

final class QuoteHandler
{
    public function __construct(private LoadPort $load)
    {
    }

    public function handler(Quote $quote): void
    {
        $segment = $this->load->segment(
            $quote->userName,
            $quote->createdAt->beginningOfDay(),
            $quote->createdAt->beginningOfTomorrow()
        );

        $original = $this->load->originalFromQuote($quote);
        $segment->quote($original, $quote);
    }
}
