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

    public function addForbbidenOriginalId(Uuid $originalId): void
    {
        $this->forbiddenIds->put($originalId->value, $originalId);
    }
 
    public function post(Post $post): void
    {
        if ($this->posts->count() === static::MAX_COUNT) {
            throw new \LogicException(ExceptionReference::MAX_LIMIT_REACHED->value);
        }

        if ($this->userName->value !== $post->getUserName()->value) {
            throw new \LogicException(ExceptionReference::INVALID_POST_FOR_SEGMENT->value);
        }

        if (!$this->hasValidCreatedAtForSegment($post)) {
            throw new \LogicException(ExceptionReference::INVALID_POST_FOR_SEGMENT->value);
        }

        $this->posts->add($post);
    }

    private function hasValidCreatedAtForSegment(Post $post): bool
    {
        $createdAtDT = DateTime::createFromFormat(
            Timestamp::FORMAT,
            $post->getCreatedAt()->value
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
