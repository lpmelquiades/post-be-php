<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\LoadPort;
use Post\CommandModel\Timestamp;

final class PostHandler
{
    public function __construct(private LoadPort $load)
    {
    }

    public function handler(Post $post): void
    {
        $now = Timestamp::now();
        $segment = $this->load->segment(
            $post->userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $segment->post($post->userName, $post->text, $now);
    }
}
