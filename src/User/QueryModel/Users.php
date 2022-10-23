<?php

declare(strict_types=1);

namespace User\QueryModel;

// Supports [RQ-08]-[RQ-09]
final class Users
{
    private array $arr;

    public function __construct()
    {
        $this->arr = [
            'john111' => ['username' => 'john123', 'joined_at' => '2017-03-26T10:58:51.010101Z'],
            'paul222' => ['username' => 'paul456', 'joined_at' => '2016-03-26T10:58:51.010101Z'],
            'ric333' => ['username' => 'ric789', 'joined_at' => '2019-03-26T10:58:51.010101Z'],
            'george000' => ['username' => 'george000', 'joined_at' => '2016-03-26T10:58:51.010101Z']
        ];
    }

    public function get(UserName $userName): array
    {
        return isset($this->arr[$userName->value]) ? $this->arr[$userName->value] : [];
    }
}