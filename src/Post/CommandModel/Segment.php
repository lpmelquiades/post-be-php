<?php

declare(strict_types=1);

namespace Post\CommandModel;

use DateTime;
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
 
    public function post(UserName $userName, Text $text, Timestamp $createdAt): void
    {
        $this->validate($userName, $createdAt);
        $this->posts->add(new Original(Uuid::build(), $userName, $text, $createdAt));
    }

    /**
     * Quote-post: Users can repost other user's posts
     * and leave a comment along with it (like Twitter Quote Tweet)
     * limited to original and reposts (not quote-posts)
     */
    public function quote(Original|Repost $post, UserName $userName, Text $text, Timestamp $createdAt): void
    {
        $this->validate($userName, $createdAt);
        $this->posts->add(new Quote(
            Uuid::build(),
            $post->id,
            $userName,
            $text,
            $createdAt
        ));
    }

    /**
     * Reposting: Users can repost other users' posts (like Twitter Retweet),
     * limited to original posts and quote posts (not reposts)
     */
    public function repost(Original|Quote $post, UserName $userName, Timestamp $createdAt): void
    {
        $this->validate($userName, $createdAt);
        $this->posts->add(new Repost(
            Uuid::build(),
            $post->id,
            $userName,
            $createdAt
        ));
    }

    private function validate(UserName $userName, Timestamp $createdAt): void
    {
        if ($this->posts->count() === static::MAX_COUNT) {
            throw new \LogicException(ExceptionReference::MAX_LIMIT_REACHED->value);
        }

        if ($this->userName->value !== $userName->value) {
            throw new \LogicException(ExceptionReference::UNFIT_FOR_SEGMENT_USERNAME->value);
        }

        if (!$this->hasValidCreatedAtForSegment($createdAt)) {
            throw new \LogicException(ExceptionReference::UNFIT_FOR_SEGMENT_DURATION->value);
        }
    }

    private function hasValidCreatedAtForSegment(Timestamp $createdAt): bool
    {
        $createdAtDT = DateTime::createFromFormat(
            Timestamp::FORMAT,
            $createdAt->value
        );
        $beginDT = DateTime::createFromFormat(Timestamp::FORMAT, $this->begin->value);
        $endDT = DateTime::createFromFormat(Timestamp::FORMAT, $this->end->value);
        if ($createdAtDT < $beginDT || $createdAtDT >= $endDT) {
            return false;
        }
        return true;
    }

    public function count(): int
    {
        return $this->posts->count();
    }
}
