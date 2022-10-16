<?php

declare(strict_types=1);

namespace Post\Tests\CommandModel;

final class DataProvider
{
    public function getOriginal(): string
    {
        return '
        {
            "username": "lee123foo",
            "text": "the lazy fox jumps over brown dog" 
        }
        ';
    }

    public function getRepost(): string
    {
        return '
        {
            "username": "lee123foo",
            "original_id": "123e4567e89b12d3a456426614174000" 
        }
        ';
    }

    public function getQuote(): string
    {
        return '
        {
            "username": "lee123foo",
            "text": "the lazy fox jumps over brown dog",
            "original_id": "123e4567e89b12d3a456426614174000" 
        }
        ';
    }
}
