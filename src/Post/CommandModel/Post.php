<?php

declare(strict_types=1);

namespace Post\CommandModel;

interface Post
{
    public function getTicket(): Ticket;

    public function getType(): PostType;

    public function hasSyncedTicket(): bool;
}
