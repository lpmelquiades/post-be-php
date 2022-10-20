<?php

declare(strict_types=1);

namespace Post\CommandModel;

interface LoadPort
{
    public function ticketsInUse(UserName $userName, Timestamp $begin, Timestamp $end): TicketsInUse;

    public function postType(Uuid $id): ?PostType;
}
