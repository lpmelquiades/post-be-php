<?php

declare(strict_types=1);

namespace Post\Tests\CommandModel;

final class InvalidDataProvider
{
    public function getInvalidOriginalWithoutUserName(): string
    {
        return '
        {
            "usernam": "lee123foo",
            "text": "the lazy fox jumps over brown dog" 
        }
        ';
    }

    public function getInvalidRepostWithoutUserName(): string
    {
        return '
        {
            "usernam": "lee123foo",
            "original_id": "123e4567e89b12d3a456426614174000" 
        }
        ';
    }

    public function getInvalidQuoteWithoutUserName(): string
    {
        return '
        {
            "username": "lee123foo",
            "text": "the lazy fox jumps over brown dog",
            "original_id": "123e4567e89b12d3a456426614174000" 
        }
        ';
    }

    public function getInvalidOriginalWithoutText(): string
    {
        return '
        {
            "username": "lee123foo",
            "tex": "the lazy fox jumps over brown dog" 
        }
        ';
    }

    public function getInvalidQuoteWithoutText(): string
    {
        return '
        {
            "username": "lee123foo",
            "texttttt": "the lazy fox jumps over brown dog",
            "original_id": "123e4567e89b12d3a456426614174000" 
        }
        ';
    }

    public function getInvalidRepostWithoutOriginalId(): string
    {
        return '
        {
            "usernam": "lee123foo",
            "original_idddd": "123e4567e89b12d3a456426614174000" 
        }
        ';
    }





    public function getInvalidQuoteWithoutOriginalId(): string
    {
        return '
        {
            "username": "lee123foo",
            "texttttt": "the lazy fox jumps over brown dog",
            "original_i": "123e4567e89b12d3a456426614174000" 
        }
        ';
    }
}
