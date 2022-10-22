<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\NextPost;
use Post\CommandModel\PostType;
use Post\CommandModel\Quote;
use Post\CommandModel\Text;
use Post\CommandModel\Ticket;
use Post\CommandModel\Timestamp;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;
use Post\Integration\PostDbFormat;

class QuoteTest extends TestCase
{
    public function testWhenQuoteIsValidWithOriginal()
    {
        $inUse = (new Data())->getTicketsInUse();
        $userName = new UserName('lee123foo');
        $text = new Text('the lazy fox jumps over brown dog');
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        $quote = new Quote(
            PostType::ORIGINAL,
            $inUse->next(),
            $id,
            $targetPostId,
            $text,
            $inUse->now
        );
        $nextPost =  new NextPost($inUse, $quote);
        $actual = (new PostDbFormat())->post($nextPost->post);
        $expected = [
            'type' => PostType::QUOTE->value,
            'id' => $id->value,
            'target_id' => $targetPostId->value,
            'text' => $text->value,
            'created_at' => $inUse->now->timestamp->value,
            'user_name' => $userName->value,
            'ticket_begin' => $inUse->now->timestamp->beginningOfDay()->value,
            'ticket_end' => $inUse->now->timestamp->beginningOfTomorrow()->value,
            'ticket_count' => 4
        ];
        $this->assertSame($expected, $actual);
    }

    public function testWhenQuoteIsValidWithRepost()
    {
        $inUse = (new Data())->getTicketsInUse();
        $userName = new UserName('lee123foo');
        $text = new Text('the lazy fox jumps over brown dog');
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        $quote = new Quote(
            PostType::REPOST,
            $inUse->next(),
            $id,
            $targetPostId,
            $text,
            $inUse->now
        );
        $nextPost =  new NextPost($inUse, $quote);
        $actual = (new PostDbFormat())->post($nextPost->post);
        $expected = [
            'type' => PostType::QUOTE->value,
            'id' => $id->value,
            'target_id' => $targetPostId->value,
            'text' => $text->value,
            'created_at' => $inUse->now->timestamp->value,
            'user_name' => $userName->value,
            'ticket_begin' => $inUse->now->timestamp->beginningOfDay()->value,
            'ticket_end' => $inUse->now->timestamp->beginningOfTomorrow()->value,
            'ticket_count' => 4
        ];
        $this->assertSame($expected, $actual);
    }

    public function testWhenQuoteTargetHasTypeQuote()
    {
        $this->expectExceptionMessage(ExceptionReference::QUOTE_OF_QUOTE->value);
        $inUse = (new Data())->getTicketsInUse();
        $text = new Text('the lazy fox jumps over brown dog');
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        new Quote(
            PostType::QUOTE,
            $inUse->next(),
            $id,
            $targetPostId,
            $text,
            $inUse->now
        );
    }

    public function testWhenQuoteHasSameIdAndTargetId()
    {
        $this->expectExceptionMessage(ExceptionReference::QUOTE_OF_QUOTE->value);
        $inUse = (new Data())->getTicketsInUse();
        $text = new Text('the lazy fox jumps over brown dog');
        $id = Uuid::build();
        new Quote(
            PostType::REPOST,
            $inUse->next(),
            $id,
            $id,
            $text,
            $inUse->now
        );
    }

    public function testWhenQuoteHasInvalidCreatedAt()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_CREATED_AT->value);
        $inUse = (new Data())->getTicketsInUse();
        $text = new Text('the lazy fox jumps over brown dog');
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        new Quote(
            PostType::REPOST,
            new Ticket(
                new UserName('lee123foo'),
                $day->beginningOfDay(),
                $day->beginningOfTomorrow(),
                1
            ),
            Uuid::build(),
            Uuid::build(),
            $text,
            $inUse->now
        );
    }    
}