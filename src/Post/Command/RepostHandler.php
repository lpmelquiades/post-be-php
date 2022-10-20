<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\PersistencePort;
use Post\CommandModel\Repost;
use Post\CommandModel\Timestamp;
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
        $now = Timestamp::now();
        $inUse = $this->load->ticketsInUse(
            $quote->userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );
        
        $post = new Repost(
            $targetPostType,
            $inUse->next(),
            Uuid::build(),
            $quote->targetPostId,
            $now
        );

        $this->persistence->save($post);
    }
}
