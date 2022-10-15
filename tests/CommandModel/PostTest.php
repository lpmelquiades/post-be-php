<?php

declare(strict_types=1);

namespace Post\Tests\CommandModel;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\Segment;

class PostTest extends TestCase
{
    public function testOK()
    {
        $post = new Segment(
            
        );
        $this->assertSame($post->post(), 'post');
        $this->assertSame($post->repost(), 'repost');
        $this->assertSame($post->quote(), 'quote');

    }
}