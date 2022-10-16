<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;
use Post\Command\Post;
use Post\Command\Quote;
use Post\Command\Repost;
use Post\CommandModel\Original;
use Post\CommandModel\Segment;
use Post\CommandModel\Text;
use Post\CommandModel\Timestamp;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;

class PostTest extends TestCase
{
    public function testWhenOriginalIsValid()
    {
        $d =  new DataProvider();
        $command = Post::build($d->getPost());
        $now = Timestamp::now();
        
        $segment = new Segment(
            $command->userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $segment->post($command->userName, $command->text, $now);
        $this->assertSame(1, $segment->count());
    }

    public function testWhenRepostIsValid()
    {
        $d =  new DataProvider();
        $command = Repost::build($d->getRepost());
        $now = Timestamp::now();
        
        $segment = new Segment(
            $command->userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $segment->repost(
            new Original(
                new Uuid($command->originalPostId->value),
                new UserName($command->userName->value),
                new Text('what a lotta love'),
                new Timestamp('2015-03-26T10:58:51.010101Z')
            ), $command->userName, $now
        );
        $this->assertSame(1, $segment->count());
    }

    public function testWhenQuoteIsValid()
    {
        $d =  new DataProvider();
        $command = Quote::build($d->getQuote());
        $now = Timestamp::now();
        
        $segment = new Segment(
            $command->userName,
            $now->beginningOfDay(),
            $now->beginningOfTomorrow()
        );

        $segment->quote(
            new Original(
                new Uuid($command->originalPostId->value),
                new UserName($command->userName->value),
                new Text('what a lotta love'),
                new Timestamp('2015-03-26T10:58:51.010101Z')
            ), $command->userName, new Text('cheers!!!!'), $now
        );
        $this->assertSame(1, $segment->count());
    }
}