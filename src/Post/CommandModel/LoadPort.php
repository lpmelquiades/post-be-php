<?php

declare(strict_types=1);

namespace Post\CommandModel;

interface LoadPort
{
    public function ticketsInUse(UserName $userName, Now $now): TicketsInUse;

    public function postType(Uuid $id): PostType;

    public function isValidUser(UserName $userName): bool;
}
