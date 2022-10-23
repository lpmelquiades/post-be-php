<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\ExceptionReference;
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
    //Supports [RQ-09]-[RQ-10]-[RQ-15]
    public function handle(QuoteCommand $command): void
    {

        //Supports [RQ-09] checks for valid user
        if (!$this->load->isValidUser($command->userName)) {
            throw new \LogicException(ExceptionReference::INVALID_USERNAME->value);
        }

        //Supports [RQ-15] loads type of the target post being quoted
        $targetPostType = $this->load->postType($command->targetPostId);
        
        // Supports [RQ-11]. A post can only be persisted with a unique persistence ticket related.
        $inUse = $this->load->ticketsInUse(
            $command->userName, new Now()
        );
        
        $post = new Quote(
            $targetPostType,
            $inUse->next(),
            Uuid::build(),
            $command->targetPostId,
            $command->text,
            $inUse->now
        );

        $this->persistence->save(new NextPost($inUse, $post));
    }
}
