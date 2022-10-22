<?php

declare(strict_types=1);

namespace Post\QueryModel;

use Post\Query\Search;

interface QueryPort
{
    public function search(Search $s): array;

    // public function count(Search $s): array;
}
