<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;
use Post\Command\RepostCommand;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\PostType;
use Post\CommandModel\Repost;
use Post\CommandModel\Ticket;
use Post\CommandModel\Timestamp;
use Post\CommandModel\Uuid;

class RepostTest extends TestCase
{
    public function testWhenRepostIsValidWithOriginal()
    {
        $d = new DataProvider();
        $command = RepostCommand::build($d->getQuote());
        $now = Timestamp::now();
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        $original = new Repost(
            PostType::ORIGINAL,
            new Ticket(
                $command->userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $targetPostId,
            $now
        );
        $actual = $original->toArray();
        $expected = [
            'type' => PostType::REPOST->value,
            'id' => $id->value,
            'target_id' => $targetPostId->value,
            'created_at' => $now->value,
            'user_name' => $command->userName->value,
            'ticket_begin' => $now->beginningOfDay()->value,
            'ticket_end' => $now->beginningOfTomorrow()->value,
            'ticket_count' => 1
        ];
        $this->assertSame($expected, $actual);
    }

    public function testWhenRepostIsValidWithQuote()
    {
        $d = new DataProvider();
        $command = RepostCommand::build($d->getQuote());
        $now = Timestamp::now();
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        $original = new Repost(
            PostType::QUOTE,
            new Ticket(
                $command->userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $targetPostId,
            $now
        );
        $actual = $original->toArray();
        $expected = [
            'type' => PostType::REPOST->value,
            'id' => $id->value,
            'target_id' => $targetPostId->value,
            'created_at' => $now->value,
            'user_name' => $command->userName->value,
            'ticket_begin' => $now->beginningOfDay()->value,
            'ticket_end' => $now->beginningOfTomorrow()->value,
            'ticket_count' => 1
        ];
        $this->assertSame($expected, $actual);
    }

    public function testWhenRepostTargetHasTypeRepost()
    {
        $this->expectExceptionMessage(ExceptionReference::REPOST_OF_REPOST->value);
        $d = new DataProvider();
        $command = RepostCommand::build($d->getQuote());
        $now = Timestamp::now();
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        new Repost(
            PostType::REPOST,
            new Ticket(
                $command->userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $targetPostId,
            $now
        );
    }

    public function testWhenRepostHasSameIdAndTargetId()
    {
        $this->expectExceptionMessage(ExceptionReference::REPOST_OF_REPOST->value);
        $d = new DataProvider();
        $command = RepostCommand::build($d->getQuote());
        $now = Timestamp::now();
        $id = Uuid::build();
        new Repost(
            PostType::QUOTE,
            new Ticket(
                $command->userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $id,
            $now
        );
    }
    
    public function testWhenQuoteHasInvalidCreatedAt()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_CREATED_AT->value);
        $d = new DataProvider();
        $command = RepostCommand::build($d->getQuote());
        $now = Timestamp::now();
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        new Repost(
            PostType::ORIGINAL,
            new Ticket(
                $command->userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $targetPostId,
            $day
        );
    }
}