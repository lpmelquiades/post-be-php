<?php

declare(strict_types=1);

namespace Post\Tests\CommandModel;

use PHPUnit\Framework\TestCase;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\PostFactory;
use Post\CommandModel\PostType;

class InvalidPostTest extends TestCase
{
    public function testWhenOriginalHasNoUserName()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_ORIGINAL->value);
        $d = new InvalidDataProvider();
        $f = new PostFactory();
        $f->build($d->getInvalidOriginalWithoutUserName(), PostType::ORIGINAL);
    }

    public function testWhenRespostHasNoUserName()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_REPOST->value);
        $d = new InvalidDataProvider();
        $f = new PostFactory();
        $f->build($d->getInvalidRepostWithoutUserName(), PostType::REPOST);
    }

    public function testWhenQuoteHasNoUserName()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_QUOTE->value);
        $d = new InvalidDataProvider();
        $f = new PostFactory();
        $f->build($d->getInvalidQuoteWithoutUserName(), PostType::QUOTE);
    }

    public function testWhenOriginalHasNoText()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_ORIGINAL->value);
        $d = new InvalidDataProvider();
        $f = new PostFactory();
        $f->build($d->getInvalidOriginalWithoutText(), PostType::ORIGINAL);
    }

    public function testWhenQuoteHasNoText()
    {
        $this->expectExceptionMessage(ExceptionReference::INVALID_QUOTE->value);
        $d = new InvalidDataProvider();
        $f = new PostFactory();
        $f->build($d->getInvalidQuoteWithoutText(), PostType::QUOTE);
    }

}