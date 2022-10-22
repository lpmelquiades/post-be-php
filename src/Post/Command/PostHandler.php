<?php

declare(strict_types=1);

namespace Post\Command;

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
    ){
    }

    public function handle(PostCommand $post): void
    {
        $inUse = $this->load->ticketsInUse($post->userName, new Now());

        $post = new Original(
            $inUse->next(),
            Uuid::build(),
            $post->text,
            $inUse->now
        );

        $this->persistence->save(new NextPost($inUse, $post));
    }
}
