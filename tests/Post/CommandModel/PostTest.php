<?php

declare(strict_types=1);

namespace Post\Tests\CommandModel;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\PostFactory;
use Post\CommandModel\PostType;
use Post\CommandModel\Segment;
use Post\CommandModel\Uuid;

class PostTest extends TestCase
{
    public function testWhenOriginalIsValid()
    {
        $x =  Uuid::build();
        $d =  new DataProvider();
        $f =  new PostFactory();
        $post = $f->build($d->getOriginal(), PostType::ORIGINAL);
        $day = $post->getCreatedAt();
        
        $segment = new Segment(
            $post->getUserName(),
            $day->beginningOfDay(),
            $day->beginningOfTomorrow()
        );

        $this->assertSame($segment->post($post), 'post');
    }
}