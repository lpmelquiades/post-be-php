<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Original;
use Post\CommandModel\PostType;
use Post\CommandModel\Text;
use Post\CommandModel\Ticket;
use Post\CommandModel\Timestamp;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;

class PostTest extends TestCase
{
    public function testWhenOriginalIsValid()
    {
        $userName = new UserName('lee123foo');
        $text =  new Text('the lazy fox jumps over brown dog');
        $now = Timestamp::now();
        $id = Uuid::build();
        $original = new Original(
            new Ticket(
                $userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $text,
            $now
        );
        $actual = $original->toArray();
        $expected = [
            'type' => PostType::ORIGINAL->value,
            'id' => $id->value,
            'text' => $text->value,
            'created_at' => $now->value,
            'user_name' => $userName->value,
            'ticket_begin' => $now->beginningOfDay()->value,
            'ticket_end' => $now->beginningOfTomorrow()->value,
            'ticket_count' => 1
        ];
        $this->assertSame($expected, $actual);
    }

    public function testWhenOriginalHasInvalidCreatedAt()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_CREATED_AT->value);
        $userName = new UserName('lee123foo');
        $text =  new Text('the lazy fox jumps over brown dog');
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        $id = Uuid::build();
        new Original(
            new Ticket(
                $userName,
                $day->beginningOfDay(),
                $day->beginningOfTomorrow(),
                1
            ),
            $id,
            $text,
            Timestamp::now()
        );
    }
}