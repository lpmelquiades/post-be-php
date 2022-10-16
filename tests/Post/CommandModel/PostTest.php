<?php

declare(strict_types=1);

namespace Post\Tests\CommandModel;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\PostFactory;
use Post\CommandModel\PostType;
use Post\CommandModel\Segment;

class PostTest extends TestCase
{
    public function testWhenOriginalIsValid()
    {
        $d =  new DataProvider();
        $f =  new PostFactory();
        $post = $f->build($d->getOriginal(), PostType::ORIGINAL);
        $day = $post->getCreatedAt();
        
        $segment = new Segment(
            $post->getUserName(),
            $day->beginningOfDay(),
            $day->beginningOfTomorrow()
        );

        $segment->post($post);
        $this->assertSame(1, $segment->count());
    }

    public function testWhenRepostIsValid()
    {
        $d =  new DataProvider();
        $f =  new PostFactory();
        $post = $f->build($d->getRepost(), PostType::REPOST);
        $day = $post->getCreatedAt();
        
        $segment = new Segment(
            $post->getUserName(),
            $day->beginningOfDay(),
            $day->beginningOfTomorrow()
        );

        $segment->post($post);
        $this->assertSame(1, $segment->count());
    }

    public function testWhenQuoteIsValid()
    {
        $d =  new DataProvider();
        $f =  new PostFactory();
        $post = $f->build($d->getQuote(), PostType::QUOTE);
        $day = $post->getCreatedAt();
        
        $segment = new Segment(
            $post->getUserName(),
            $day->beginningOfDay(),
            $day->beginningOfTomorrow()
        );
        $segment->post($post);
        $this->assertSame(1, $segment->count());
    }
}