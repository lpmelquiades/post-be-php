<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\ExceptionReference;
use Post\CommandModel\LoadPort;
use Post\CommandModel\NextPost;
use Post\CommandModel\Now;
use Post\CommandModel\Original;
use Post\CommandModel\PersistencePort;
use Post\CommandModel\Uuid;

final class PostHandler
{
    public function __construct(
        private LoadPort $load,
        private PersistencePort $persistence
    ) {
    }

    // Supports [RQ-04]-[RQ-07]-[RQ-09]
    public function handle(PostCommand $command): void
    {
        // Checks username. // Supports [RQ-07]-[RQ-09]
        if (!$this->load->isValidUser($command->userName)) {
            throw new \LogicException(ExceptionReference::INVALID_USERNAME->value);
        }

        // A post can only be persisted with a unique ticket related.
        $inUse = $this->load->ticketsInUse($command->userName, new Now());

        // Create original post with next available ticket (MAX 5) per user per day.
        $post = new Original(
            $inUse->next(),
            Uuid::build(),
            $command->text,
            $inUse->now
        );

        $this->persistence->save(new NextPost($inUse, $post));
    }
}
