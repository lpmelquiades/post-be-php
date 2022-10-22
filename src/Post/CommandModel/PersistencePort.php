<?php

declare(strict_types=1);

namespace Post\CommandModel;

interface PersistencePort
{
    public function save(NextPost $next): void;
}
