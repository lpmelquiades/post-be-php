<?php

declare(strict_types=1);

namespace Post\CommandModel;

use DateTime;
use Exception;
use Illuminate\Support\Collection;

final class Segment
{
    public const MAX_COUNT = 5;

    private Collection $posts;

    public function __construct(
        public readonly UserName $userName,
        public readonly Timestamp $begin,
        public readonly Timestamp $end
    ) {
        $this->posts = new Collection();
    }
 
    public function post(Post $post): string
    {
        if ($this->posts->count() === static::MAX_COUNT) {
            throw new \LogicException(ExceptionReference::MAX_LIMIT_REACHED->value);
        }

        return match($post->getType()->value) {
            PostType::ORIGINAL->value => $this->original($post),
            PostType::REPOST->value => $this->repost($post),
            PostType::QUOTE->value => $this->quote($post),
            'default' => throw new \LogicException(ExceptionReference::INVALID_POST->value)            
        };
    }

    public function original(Original $post)
    {
        return 'post';
    }

    public function repost(Repost $repost)
    {
        return 'repost';
    }

    public function quote(Quote $quote)
    {
        return 'quote';
    }
}
