<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\Post;
use Post\CommandModel\Repost;
use Post\CommandModel\Timestamp;

final class RepostHandler
{
    public function __construct(private LoadPort $load)
    {
    }

    public function handle(Repost $repost): void
    {
        $now = Timestamp::now();
        $segment = $this->load->segment(
            $repost->userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $original = $this->load->original($repost->originalPostId);
        $segment->repost($original, $repost->userName, $now);
    }

}
