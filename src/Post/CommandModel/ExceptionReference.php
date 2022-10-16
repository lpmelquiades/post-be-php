<?php

declare(strict_types=1);

namespace Post\CommandModel;

enum ExceptionReference: String
{
    case INVALID_POST = 'INVALID_POST';
    case INVALID_ORIGINAL = 'INVALID_ORIGINAL';
    case INVALID_REPOST = 'INVALID_REPOST';
    case INVALID_QUOTE = 'INVALID_QUOTE';
    case INVALID_TEXT = 'INVALID_TEXT';
    case INVALID_UUID = 'INVALID_UUID';
    case INVALID_TIMESTAMP = 'INVALID_TIMESTAMP';  
    case MAX_LIMIT_REACHED = 'MAX_LIMIT_REACHED';
    case INVALID_JSON_SCHEMA = 'INVALID_JSON_SCHEMA';

}