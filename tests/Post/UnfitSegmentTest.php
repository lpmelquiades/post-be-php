<?php

declare(strict_types=1);

namespace Post\Tests;

use PHPUnit\Framework\TestCase;

class UnfitSegmentTest extends TestCase
{
    // public function testWhenPostHasUnfitSegmentForCreatedAt()
    // {
    //     $this->expectExceptionMessage(ExceptionReference::UNFIT_FOR_SEGMENT_DURATION->value);
    //     $d =  new DataProvider();
    //     $command = Post::build($d->getPost());
    //     $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        
    //     $segment = new Segment(
    //         $command->userName,
    //         $day->beginningOfDay(),
    //         $day->beginningOfTomorrow()
    //     );

    //     $segment->post($command->userName, $command->text, Timestamp::now());
    // }

    // public function testWhenRepostHasUnfitSegmentForCreatedAt()
    // {
    //     $this->expectExceptionMessage(ExceptionReference::UNFIT_FOR_SEGMENT_DURATION->value);
    //     $d =  new DataProvider();
    //     $command = Repost::build($d->getRepost());
    //     $day = new Timestamp('2018-03-26T10:58:51.010101Z');
        
    //     $segment = new Segment(
    //         $command->userName,
    //         $day->beginningOfDay(),
    //         $day->beginningOfTomorrow()
    //     );

    //     $segment->repost(
    //         new Original(
    //             new Uuid($command->originalPostId->value),
    //             new UserName($command->userName->value),
    //             new Text('what a lotta love'),
    //             new Timestamp('2015-03-26T10:58:51.010101Z')
    //         ), $command->userName, Timestamp::now()
    //     );
    // }


    // public function testWhenQuoteHasUnfitSegmentForCreatedAt()
    // {
    //     $this->expectExceptionMessage(ExceptionReference::UNFIT_FOR_SEGMENT_DURATION->value);
    //     $d =  new DataProvider();
    //     $command = Quote::build($d->getQuote());
    //     $day = new Timestamp('2018-03-26T10:58:51.010101Z');
        
    //     $segment = new Segment(
    //         $command->userName,
    //         $day->beginningOfDay(),
    //         $day->beginningOfTomorrow()
    //     );

    //     $segment->quote(
    //         new Original(
    //             new Uuid($command->originalPostId->value),
    //             new UserName($command->userName->value),
    //             new Text('what a lotta love'),
    //             new Timestamp('2015-03-26T10:58:51.010101Z')
    //         ), $command->userName, new Text('cheers!!!!'), Timestamp::now()
    //     );
    //     $this->assertSame(1, $segment->count());
    // }

    // public function testWhenPostHasUnfitSegmentForUserName()
    // {
    //     $this->expectExceptionMessage(ExceptionReference::UNFIT_FOR_SEGMENT_USERNAME->value);
    //     $d =  new DataProvider();
    //     $command = Post::build($d->getPost());
    //     $now = Timestamp::now();
        
    //     $segment = new Segment(
    //         new UserName('johndow2233'),
    //         $now->beginningOfDay(),
    //         $now->beginningOfTomorrow()
    //     );

    //     $segment->post($command->userName, $command->text, $now);
    //     $this->assertSame(1, $segment->count());
    // }

    // public function testWhenRepostHasUnfitSegmentForUserName()
    // {
    //     $this->expectExceptionMessage(ExceptionReference::UNFIT_FOR_SEGMENT_USERNAME->value);
    //     $d =  new DataProvider();
    //     $command = Repost::build($d->getRepost());
    //     $now = Timestamp::now();
        
    //     $segment = new Segment(
    //         new UserName('johndow2233'),
    //         $now->beginningOfDay(),
    //         $now->beginningOfTomorrow()
    //     );

    //     $segment->repost(
    //         new Original(
    //             new Uuid($command->originalPostId->value),
    //             new UserName($command->userName->value),
    //             new Text('what a lotta love'),
    //             new Timestamp('2015-03-26T10:58:51.010101Z')
    //         ), $command->userName, $now
    //     );
    //     $this->assertSame(1, $segment->count());
    // }

    // public function testWhenQuoteHasUnfitSegmentForUserName()
    // {
    //     $this->expectExceptionMessage(ExceptionReference::UNFIT_FOR_SEGMENT_USERNAME->value);
    //     $d =  new DataProvider();
    //     $command = Quote::build($d->getQuote());
    //     $now = Timestamp::now();
        
    //     $segment = new Segment(
    //         new UserName('johndow2233'),
    //         $now->beginningOfDay(),
    //         $now->beginningOfTomorrow()
    //     );

    //     $segment->quote(
    //         new Original(
    //             new Uuid($command->originalPostId->value),
    //             new UserName($command->userName->value),
    //             new Text('what a lotta love'),
    //             new Timestamp('2015-03-26T10:58:51.010101Z')
    //         ), $command->userName, new Text('cheers!!!!'), $now
    //     );
    //     $this->assertSame(1, $segment->count());
    // }
}