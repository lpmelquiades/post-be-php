<?php

declare(strict_types=1);

namespace Post\Tests\CommandModel;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\PostFactory;
use Post\CommandModel\PostType;
use Post\CommandModel\Segment;
use Post\CommandModel\Timestamp;

class InvalidPostForSegmentTest extends TestCase
{
    public function testWhenOriginalIsNotValidForSegment()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_POST_FOR_SEGMENT->value);
        $d =  new DataProvider();
        $f =  new PostFactory();
        $post = $f->build($d->getOriginal(), PostType::ORIGINAL);
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        
        $segment = new Segment(
            $post->getUserName(),
            $day->beginningOfDay(),
            $day->beginningOfTomorrow()
        );

        $segment->post($post);
    }

    public function testWhenRepostIsNotValidForSegment()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_POST_FOR_SEGMENT->value);
        $d =  new DataProvider();
        $f =  new PostFactory();
        $post = $f->build($d->getRepost(), PostType::REPOST);
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        
        $segment = new Segment(
            $post->getUserName(),
            $day->beginningOfDay(),
            $day->beginningOfTomorrow()
        );

        $segment->post($post);
    }

    public function testWhenQuoteIsNotValidForSegment()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_POST_FOR_SEGMENT->value);
        $d =  new DataProvider();
        $f =  new PostFactory();
        $post = $f->build($d->getQuote(), PostType::QUOTE);
        $day = new Timestamp('2015-03-26T10:58:51.010101Z');
        
        $segment = new Segment(
            $post->getUserName(),
            $day->beginningOfDay(),
            $day->beginningOfTomorrow()
        );

        $segment->post($post);
    }
}