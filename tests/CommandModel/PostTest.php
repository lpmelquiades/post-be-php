<?php

declare(strict_types=1);

namespace SailingParseMatch\Tests\Model;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\Post;

class PostTest extends TestCase
{
    public function testOK()
    {
        $post = new Post();
        $this->assertSame($post->post(), 'post');
        $this->assertSame($post->repost(), 'repost');
        $this->assertSame($post->quote(), 'quote');

    }
}