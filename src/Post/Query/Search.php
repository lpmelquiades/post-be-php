<?php

declare(strict_types=1);

namespace Post\Query;

use Post\QueryModel\Timestamp;
use Post\QueryModel\ExceptionReference;
use Post\QueryModel\UserName;
use Post\QueryModel\UserNames;

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

    public static function build(string $uriQuery): static
    {
        parse_str($uriQuery, $arr);
        if (!isset($arr['users'])) {
            throw new \LogicException(ExceptionReference::INVALID_QUERY->value);
        }

        $userNames = new UserNames();
        foreach ($arr['users'] as $u) {
            $userNames->add(new UserName($u));
        }

        return new static(
            $userNames,
            isset($arr['begin']) ? new Timestamp($arr['begin']): null,
            isset($arr['end']) ? new Timestamp($arr['end']): null,
            isset($arr['page_size']) ? intval($arr['page_size']): 10,
            isset($arr['page']) ? intval($arr['page']): 1    
        );
    }
}
