<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\Original;
use Post\CommandModel\PersistencePort;
use Post\CommandModel\Timestamp;
use Post\CommandModel\Uuid;

final class PostHandler
{
    public function __construct(
        private LoadPort $load,
        private PersistencePort $persistence
    ){
    }

    public function handle(PostCommand $post): void
    {
        $now = Timestamp::now();
        $inUse = $this->load->ticketsInUse(
            $post->userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $post = new Original(
            $inUse->next(),
            Uuid::build(),
            $post->text,
            $now
        );

        $this->persistence->save($post);
    }
}
