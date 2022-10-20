<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;
use Post\Command\PostCommand;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Original;
use Post\CommandModel\PostType;
use Post\CommandModel\Ticket;
use Post\CommandModel\Timestamp;
use Post\CommandModel\Uuid;

class PostTest extends TestCase
{
    public function testWhenOriginalIsValid()
    {
        $d = new DataProvider();
        $command = PostCommand::build($d->getPost());
        $now = Timestamp::now();
        $id = Uuid::build();
        $original = new Original(
            new Ticket(
                $command->userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $command->text,
            $now
        );
        $actual = $original->toArray();
        $expected = [
            'type' => PostType::ORIGINAL->value,
            'id' => $id->value,
            'text' => $command->text->value,
            'created_at' => $now->value,
            'user_name' => $command->userName->value,
            'ticket_begin' => $now->beginningOfDay()->value,
            'ticket_end' => $now->beginningOfTomorrow()->value,
            'ticket_count' => 1
        ];
        $this->assertSame($expected, $actual);
    }

    public function testWhenOriginalHasInvalidCreatedAt()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_CREATED_AT->value);
        $d = new DataProvider();
        $command = PostCommand::build($d->getPost());
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        $id = Uuid::build();
        new Original(
            new Ticket(
                $command->userName,
                $day->beginningOfDay(),
                $day->beginningOfTomorrow(),
                1
            ),
            $id,
            $command->text,
            Timestamp::now()
        );
    }
}