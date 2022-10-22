<?php

declare(strict_types=1);

namespace Post\CommandModel;

interface PersistencePort
{
    // Supports [RQ-04].
    public function save(NextPost $next): void;
}
