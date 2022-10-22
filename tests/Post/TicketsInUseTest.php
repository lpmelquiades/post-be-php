<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Ticket;
use Post\CommandModel\TicketsInUse;
use Post\CommandModel\Timestamp;
use Post\CommandModel\UserName;

class TicketsInUseTest extends TestCase
{
    public function testWhenTicketsInUseReachLimitWithAdd()
    {
        $this->expectExceptionMessage(ExceptionReference::POST_LIMIT_REACHED->value);
        $userName = new UserName('lee123foo');
        $now = Timestamp::now();

        $inUse = new TicketsInUse(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            1
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            2
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            3
        )); 
        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            4
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            5
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            5
        ));
    }

    public function testWhenTicketsInUseReachLimitWithNext()
    {
        $this->expectExceptionMessage(ExceptionReference::POST_LIMIT_REACHED->value);
        $userName = new UserName('lee123foo');
        $now = Timestamp::now();

        $inUse = new TicketsInUse(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            1
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            2
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            3
        )); 
        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            4
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            5
        ));
        $inUse->next();
    }

    public function testWhenTicketsInUseAddTicketInvalidUserName()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_TICKET->value);
        $userName = new UserName('lee123foo');
        $now = Timestamp::now();

        $inUse = new TicketsInUse(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $inUse->add(new Ticket(
            new UserName('notaname'),
            $now->beginningOfDay(),
            $now->beginningOfTomorrow(),
            1
        ));
        $inUse->next();
    }

    public function testWhenTicketsInUseAddTicketInvalidBegin()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_TICKET->value);
        $userName = new UserName('lee123foo');
        $now = Timestamp::now();
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');

        $inUse = new TicketsInUse(
            $userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $inUse->add(new Ticket(
            $userName,
            $day->beginningOfDay(),
            $now->beginningOfTomorrow(),
            1
        ));
        $inUse->next();
    }

    public function testWhenTicketsInUseAddTicketInvalidEnd()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_TICKET->value);
        $userName = new UserName('lee123foo');
        $now = Timestamp::now();
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');

        $inUse = new TicketsInUse(
            $userName,
            $day->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $inUse->add(new Ticket(
            $userName,
            $day->beginningOfDay(),
            $day->beginningOfTomorrow(),
            1
        ));
        $inUse->next();
    }

    public function testWhenTicketsInUseHasWrongChronology()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_CHRONOLOGY->value);
        $userName = new UserName('lee123foo');
        $now = Timestamp::now();
        new TicketsInUse(
            $userName,
            $now->beginningOfTomorrow(),
            $now->beginningOfDay()
        );
    }
}