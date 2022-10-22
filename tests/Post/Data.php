<?php

declare(strict_types=1);

namespace Post\Tests;

use Post\CommandModel\Now;
use Post\CommandModel\Text;
use Post\CommandModel\Ticket;
use Post\CommandModel\TicketsInUse;
use Post\CommandModel\UserName;

final class Data
{
    public function getTicketsInUse(): TicketsInUse
    {
        $userName = new UserName('lee123foo');
        $now = new Now();
        $inUse = new TicketsInUse($userName, $now);

        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            1
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            2
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            3
        ));

        return $inUse;
    }
}
