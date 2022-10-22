<?php

declare(strict_types=1);

namespace Post\Query;

use Post\QueryModel\Timestamp;
use Post\QueryModel\UserNames;

//Supports [RQ-01]-[RQ-02]-[RQ-03]
final class Search
{
    public function __construct (
        public readonly UserNames $userNames,
        public readonly ?Timestamp $begin,
        public readonly ?Timestamp $end,
        public readonly int $pageSize,
        public readonly int $page
    ){
    }
}
