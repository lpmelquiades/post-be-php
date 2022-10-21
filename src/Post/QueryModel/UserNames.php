<?php

declare(strict_types=1);

namespace Post\QueryModel;

use Illuminate\Support\Collection;

final class UserNames
{
    private Collection $coll;

    public function __construct()
    {
        $this->coll = new Collection();
    }

    public function add(UserName $userName): void
    {
        $this->coll->add($userName);
    }

    public function count(): int
    {
        return $this->coll->count();
    }

    public function toArray(): array
    {
        return $this->coll->map(function(UserName $u): string {
            return $u->value;
        })->toArray();
    }
}