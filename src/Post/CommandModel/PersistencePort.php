<?php

declare(strict_types=1);

namespace Post\CommandModel;

interface PersistencePort
{
    // Supports [RQ-04]-[RQ-07]-[RQ-10].
    // NexPost is needed to persist a new Post
    public function save(NextPost $next): void;
}
