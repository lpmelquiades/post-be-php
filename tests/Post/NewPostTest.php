<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\NextPost;
use Post\CommandModel\Now;
use Post\CommandModel\Original;
use Post\CommandModel\PostType;
use Post\CommandModel\Text;
use Post\CommandModel\Ticket;
use Post\CommandModel\Timestamp;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;

class NewPostTest extends TestCase
{
    public function testWhenBeginsAreDifferent()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_TICKET->value);
        $inUse = (new Data())->getTicketsInUse();
        $userName = new UserName('lee123foo');
        $text =  new Text('the lazy fox jumps over brown dog');
        $now = $inUse->now;
        $id = Uuid::build();
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        $original = new Original(
            new Ticket(
                $userName,
                $day,
                $inUse->end,
                1
            ),
            $id,
            $text,
            $now
        );
        new NextPost($inUse, $original);
    }

    public function testWhenEndsAreDifferent()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_TICKET->value);
        $inUse = (new Data())->getTicketsInUse();
        $userName = new UserName('lee123foo');
        $text =  new Text('the lazy fox jumps over brown dog');
        $now = $inUse->now;
        $id = Uuid::build();
        $original = new Original(
            new Ticket(
                $userName,
                $inUse->begin,
                $inUse->end->beginningOfTomorrow(),
                1
            ),
            $id,
            $text,
            $now
        );
        new NextPost($inUse, $original);
    }

}