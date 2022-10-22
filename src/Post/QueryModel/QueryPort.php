<?php

declare(strict_types=1);

namespace Post\QueryModel;

use Post\Query\Count;
use Post\Query\Search;

interface QueryPort
{
    // Supports [RQ-01].
    public function search(Search $s): array;

    // Supports [RQ-01].
    public function count(Count $s): array;

    public function getPost(Uuid $id): array;
}
