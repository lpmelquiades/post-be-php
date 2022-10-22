<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\NextPost;
use Post\CommandModel\PostType;
use Post\CommandModel\Repost;
use Post\CommandModel\Ticket;
use Post\CommandModel\Timestamp;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;
use Post\Integration\PostDbFormat;

class RepostTest extends TestCase
{
    public function testWhenRepostIsValidWithOriginal()
    {
        $inUse = (new Data())->getTicketsInUse();
        $userName = new UserName('lee123foo');
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        $repost = new Repost(
            PostType::ORIGINAL,
            $inUse->next(),
            $id,
            $targetPostId,
            $inUse->now
        );
        $nextPost =  new NextPost($inUse, $repost);
        $actual = (new PostDbFormat())->post($nextPost->post);
        $expected = [
            'type' => PostType::REPOST->value,
            'id' => $id->value,
            'target_id' => $targetPostId->value,
            'created_at' => $inUse->now->timestamp->value,
            'user_name' => $userName->value,
            'ticket_begin' => $inUse->now->timestamp->beginningOfDay()->value,
            'ticket_end' => $inUse->now->timestamp->beginningOfTomorrow()->value,
            'ticket_count' => 4
        ];
        $this->assertSame($expected, $actual);
    }

    public function testWhenRepostIsValidWithQuote()
    {
        $inUse = (new Data())->getTicketsInUse();
        $userName = new UserName('lee123foo');
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        $repost = new Repost(
            PostType::QUOTE,
            $inUse->next(),
            $id,
            $targetPostId,
            $inUse->now
        );
        $nextPost =  new NextPost($inUse, $repost);
        $actual = (new PostDbFormat())->post($nextPost->post);
        $expected = [
            'type' => PostType::REPOST->value,
            'id' => $id->value,
            'target_id' => $targetPostId->value,
            'created_at' => $inUse->now->timestamp->value,
            'user_name' => $userName->value,
            'ticket_begin' => $inUse->now->timestamp->beginningOfDay()->value,
            'ticket_end' => $inUse->now->timestamp->beginningOfTomorrow()->value,
            'ticket_count' => 4
        ];
        $this->assertSame($expected, $actual);
    }

    public function testWhenRepostTargetHasTypeRepost()
    {
        $this->expectExceptionMessage(ExceptionReference::REPOST_OF_REPOST->value);
        $inUse = (new Data())->getTicketsInUse();
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        new Repost(
            PostType::REPOST,
            $inUse->next(),
            $id,
            $targetPostId,
            $inUse->now
        );
    }

    public function testWhenRepostHasSameIdAndTargetId()
    {
        $this->expectExceptionMessage(ExceptionReference::REPOST_OF_REPOST->value);
        $inUse = (new Data())->getTicketsInUse();
        $id = Uuid::build();
        new Repost(
            PostType::QUOTE,
            $inUse->next(),
            $id,
            $id,
            $inUse->now
        );
    }
    
    public function testWhenQuoteHasInvalidCreatedAt()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_CREATED_AT->value);
        $inUse = (new Data())->getTicketsInUse();
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        $userName = new UserName('lee123foo');
        $id = Uuid::build();
        $targetPostId = Uuid::build();
        new Repost(
            PostType::ORIGINAL,
            new Ticket(
                $userName,
                $day->beginningOfDay(),
                $day->beginningOfTomorrow(),
                1
            ),
            $id,
            $targetPostId,
            $inUse->now
        );
    }
}