<?php

declare(strict_types=1);

namespace Post\CommandModel;

enum PostType: String
{
    case ORIGINAL = 'ORIGINAL';
    case REPOST = 'REPOST';
    case QUOTE = 'QUOTE';
}
