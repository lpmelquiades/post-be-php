<?php

declare(strict_types=1);

namespace Post\QueryModel;

use Post\Query\Count;
use Post\Query\Search;

interface QueryPort
{
    // Supports [RQ-01]-[RQ-02]-[RQ-03]-[RQ-06].
    public function search(Search $s): array;

    // Supports [RQ-01]-[RQ-02]-[RQ-03]-[RQ-05]-[RQ-06].
    public function count(Count $s): array;

    // Supports [RQ-01]-[RQ-02]-[RQ-03]-[RQ-06].
    public function getPost(Uuid $id): array;
}
