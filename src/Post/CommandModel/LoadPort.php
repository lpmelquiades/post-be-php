<?php

declare(strict_types=1);

namespace Post\CommandModel;

interface LoadPort
{
    /** Supports [RQ-11]. 
    * Now and TicketsInUse are required to get
    * the next persistence ticket for a post.
    */
    public function ticketsInUse(UserName $userName, Now $now): TicketsInUse;

    // Supports [RQ-14]-[RQ-15]
    public function postType(Uuid $id): PostType;

    // Supports [RQ-07]-[RQ-09]
    public function isValidUser(UserName $userName): bool;
}
