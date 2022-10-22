<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\PostType;
use Post\CommandModel\Quote;
use Post\CommandModel\Text;
use Post\CommandModel\Ticket;
use Post\CommandModel\Timestamp;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;

class QuoteTest extends TestCase
{
    public function testWhenQuoteIsValidWithOriginal()
    {
        $userName = new UserName('lee123foo');
        $text = new Text('the lazy fox jumps over brown dog');
        $now = Timestamp::now();
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        $original = new Quote(
            PostType::ORIGINAL,
            new Ticket(
                $userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $targetPostId,
            $text,
            $now
        );
        $actual = $original->toArray();
        $expected = [
            'type' => PostType::QUOTE->value,
            'id' => $id->value,
            'target_id' => $targetPostId->value,
            'text' => $text->value,
            'created_at' => $now->value,
            'user_name' => $userName->value,
            'ticket_begin' => $now->beginningOfDay()->value,
            'ticket_end' => $now->beginningOfTomorrow()->value,
            'ticket_count' => 1
        ];
        $this->assertSame($expected, $actual);
    }

    public function testWhenQuoteIsValidWithRepost()
    {
        $userName = new UserName('lee123foo');
        $text = new Text('the lazy fox jumps over brown dog');
        $now = Timestamp::now();
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        $original = new Quote(
            PostType::REPOST,
            new Ticket(
                $userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $targetPostId,
            $text,
            $now
        );
        $actual = $original->toArray();
        $expected = [
            'type' => PostType::QUOTE->value,
            'id' => $id->value,
            'target_id' => $targetPostId->value,
            'text' => $text->value,
            'created_at' => $now->value,
            'user_name' => $userName->value,
            'ticket_begin' => $now->beginningOfDay()->value,
            'ticket_end' => $now->beginningOfTomorrow()->value,
            'ticket_count' => 1
        ];
        $this->assertSame($expected, $actual);
    }

    public function testWhenQuoteTargetHasTypeQuote()
    {
        $this->expectExceptionMessage(ExceptionReference::QUOTE_OF_QUOTE->value);
        $userName = new UserName('lee123foo');
        $text = new Text('the lazy fox jumps over brown dog');
        $now = Timestamp::now();
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        new Quote(
            PostType::QUOTE,
            new Ticket(
                $userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $targetPostId,
            $text,
            $now
        );
    }

    public function testWhenQuoteHasSameIdAndTargetId()
    {
        $this->expectExceptionMessage(ExceptionReference::QUOTE_OF_QUOTE->value);
        $userName = new UserName('lee123foo');
        $text = new Text('the lazy fox jumps over brown dog');
        $now = Timestamp::now();
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        new Quote(
            PostType::REPOST,
            new Ticket(
                $userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $id,
            $text,
            $now
        );
    }

    public function testWhenQuoteHasInvalidCreatedAt()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_CREATED_AT->value);
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        $userName = new UserName('lee123foo');
        $text = new Text('the lazy fox jumps over brown dog');
        $now = Timestamp::now();
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        new Quote(
            PostType::ORIGINAL,
            new Ticket(
                $userName,
                $now->beginningOfDay(),
                $now->beginningOfTomorrow(),
                1
            ),
            $id,
            $targetPostId,
            $text,
            $day
        );
    }
}