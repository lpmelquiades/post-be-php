<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Now;
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
        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            4
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            5
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            5
        ));
    }

    public function testWhenTicketsInUseReachLimitWithNext()
    {
        $this->expectExceptionMessage(ExceptionReference::POST_LIMIT_REACHED->value);
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
        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            4
        ));
        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            5
        ));
        $inUse->next();
    }

    public function testWhenTicketsInUseAddTicketInvalidUserName()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_TICKET->value);
        $userName = new UserName('lee123foo');
        $now = new Now();
        $inUse = new TicketsInUse($userName, $now);

        $inUse->add(new Ticket(
            new UserName('notaname'),
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            1
        ));
        $inUse->next();
    }

    public function testWhenTicketsInUseAddTicketInvalidBegin()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_TICKET->value);
        $userName = new UserName('lee123foo');
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        
        $now = Timestamp::now();
        $now = new Now();
        $inUse = new TicketsInUse($userName, $now);

        $inUse->add(new Ticket(
            $userName,
            $day->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            1
        ));
        $inUse->next();
    }

    public function testWhenTicketsInUseAddTicketInvalidEnd()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_TICKET->value);
        $userName = new UserName('lee123foo');
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        $now = new Now();
        $inUse = new TicketsInUse($userName, $now);

        $inUse->add(new Ticket(
            $userName,
            $day->beginningOfDay(),
            $day->beginningOfTomorrow(),
            1
        ));
        $inUse->next();
    }

    public function testWhenTicketsInUseHasNextAs1()
    {
        $userName = new UserName('lee123foo');
        $now = new Now();
        $inUse = new TicketsInUse($userName, $now);

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
        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            5
        ));

        $next = $inUse->next();
        $this->assertSame($next->value, 1);
    }

    public function testWhenTicketsInUseHasNextAs2()
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
            3
        )); 
        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            5
        ));

        $next = $inUse->next();
        $this->assertSame($next->value, 2);
    }

    public function testWhenTicketsInUseHasNextAs3()
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
            5
        ));

        $next = $inUse->next();
        $this->assertSame($next->value, 3);
    }

    public function testWhenTicketsInUseHasNextAs4()
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

        $next = $inUse->next();
        $this->assertSame($next->value, 4);
    }

    public function testWhenTicketsInUseHasNextAs5()
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
        $inUse->add(new Ticket(
            $userName,
            $now->timestamp->beginningOfDay(),
            $now->timestamp->beginningOfTomorrow(),
            4
        ));

        $next = $inUse->next();
        $this->assertSame($next->value, 5);
    }
}