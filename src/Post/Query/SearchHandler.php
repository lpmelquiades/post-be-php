<?php

declare(strict_types=1);

namespace Post\Query;

use Post\QueryModel\QueryPort;

final class SearchHandler
{
    public function __construct (
        private QueryPort $query
    ){
    }

    public function handle(Search $search): array
    {
        return $this->query->search($search);
    }
}
