<?php

declare(strict_types=1);

namespace Post\Query;

use Post\QueryModel\Timestamp;
use Post\QueryModel\UserName;
use Post\QueryModel\UserNames;

final class Count
{
    public function __construct (
        public readonly UserNames $userNames,
        public readonly ?Timestamp $begin,
        public readonly ?Timestamp $end
    ){
    }
}
