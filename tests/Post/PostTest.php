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
use Post\Integration\PostDbFormat;

class PostTest extends TestCase
{
    public function testWhenOriginalIsValid()
    {
        $inUse = (new Data())->getTicketsInUse();
        $userName = new UserName('lee123foo');
        $text =  new Text('the lazy fox jumps over brown dog');
        $now = $inUse->now;
        $id = Uuid::build();
        $original = new Original(
            $inUse->next(),
            $id,
            $text,
            $now
        );
        $nextPost =  new NextPost($inUse, $original);
        $actual = (new PostDbFormat())->post($nextPost->post);
        $expected = [
            'type' => PostType::ORIGINAL->value,
            'id' => $id->value,
            'text' => $text->value,
            'created_at' => $now->timestamp->value,
            'user_name' => $userName->value,
            'ticket_begin' => $now->timestamp->beginningOfDay()->value,
            'ticket_end' => $now->timestamp->beginningOfTomorrow()->value,
            'ticket_count' => 4
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
            new Now()
        );
    }

}