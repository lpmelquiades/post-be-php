<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\PersistencePort;
use Post\CommandModel\Quote;
use Post\CommandModel\Timestamp;
use Post\CommandModel\Uuid;

final class QuoteHandler
{
    public function __construct(
        private LoadPort $load,
        private PersistencePort $persistence
    ) {
    }

    public function handle(QuoteCommand $quote): void
    {
        $targetPostType = $this->load->postType($quote->targetPostId);
        $now = Timestamp::now();
        $inUse = $this->load->ticketsInUse(
            $quote->userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );
        
        $post = new Quote(
            $targetPostType,
            $inUse->next(),
            Uuid::build(),
            $quote->targetPostId,
            $quote->text,
            $now
        );

        $this->persistence->save($post);
    }
}
