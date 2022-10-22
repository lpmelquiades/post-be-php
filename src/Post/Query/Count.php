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

    public static function build(string $uriQuery): static
    {
        parse_str($uriQuery, $arr);
        $userNames = new UserNames();
        if (isset($arr['users'])) {
            foreach ($arr['users'] as $u) {
                $userNames->add(new UserName($u));
            }
        }

        return new static(
            $userNames,
            isset($arr['begin']) ? new Timestamp($arr['begin']): null,
            isset($arr['end']) ? new Timestamp($arr['end']): null
        );
    }
}
