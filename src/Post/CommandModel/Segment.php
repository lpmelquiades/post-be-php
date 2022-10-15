<?php

declare(strict_types=1);

namespace Post\CommandModel;

use Illuminate\Support\Collection;

final class Segment
{
    public const MAX_COUNT = 5;

    private Collection $posts;

    public function __construct(
        public readonly Timestamp $begin,
        public readonly Timestamp $end
    ) {
        $this->posts = new Collection();
    }
 
    public function post(Original $post)
    {
        if ($this->posts->count() === static::MAX_COUNT) {
            throw new \LogicException(ExceptionReference::MAX_LIMIT_REACHED->value);
        }
        return 'post';
    }

    public function repost(Repost $repost)
    {
        if ($this->posts->count() === static::MAX_COUNT) {
            throw new \LogicException(ExceptionReference::MAX_LIMIT_REACHED->value);
        }
        return 'repost';
    }

    public function quote(Quote $quote)
    {
        if ($this->posts->count() === static::MAX_COUNT) {
            throw new \LogicException(ExceptionReference::MAX_LIMIT_REACHED->value);
        }
        return 'quote';
    }
}