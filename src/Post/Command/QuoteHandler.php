<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\NextPost;
use Post\CommandModel\Now;
use Post\CommandModel\PersistencePort;
use Post\CommandModel\Quote;
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
        $inUse = $this->load->ticketsInUse(
            $quote->userName, new Now()
        );
        
        $post = new Quote(
            $targetPostType,
            $inUse->next(),
            Uuid::build(),
            $quote->targetPostId,
            $quote->text,
            $inUse->now
        );

        $this->persistence->save(new NextPost($inUse, $post));
    }
}
