<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\Post;
use Post\CommandModel\Repost;

final class RepostHandler
{
    public function __construct(private LoadPort $load)
    {
    }

    public function handler(Repost $repost): void
    {
        $segment = $this->load->segment(
            $repost->userName,
            $repost->createdAt->beginningOfDay(),
            $repost->createdAt->beginningOfTomorrow()
        );

        $original = $this->load->originalFromRepost($repost);
        $segment->repost($original, $repost);
    }

}
