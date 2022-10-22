<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\NextPost;
use Post\CommandModel\Now;
use Post\CommandModel\PersistencePort;
use Post\CommandModel\Repost;
use Post\CommandModel\Uuid;

final class RepostHandler
{
    public function __construct(
        private LoadPort $load,
        private PersistencePort $persistence
    ) {
    }

    public function handle(RepostCommand $quote): void
    {
        $targetPostType = $this->load->postType($quote->targetPostId);
        $inUse = $this->load->ticketsInUse(
            $quote->userName,
            new Now()
        );
        
        $post = new Repost(
            $targetPostType,
            $inUse->next(),
            Uuid::build(),
            $quote->targetPostId,
            $inUse->now
        );

        $this->persistence->save(new NextPost($inUse, $post));
    }
}
