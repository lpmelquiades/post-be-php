<?php

declare(strict_types=1);

namespace Post\Tests;

final class DataProvider
{
    public function getPost(): string
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
            "target_id": "123e4567e89b12d3a456426614174000" 
        }
        ';
    }

    public function getQuote(): string
    {
        return '
        {
            "username": "lee123foo",
            "text": "the lazy fox jumps over brown dog",
            "target_id": "123e4567e89b12d3a456426614174000" 
        }
        ';
    }
}
