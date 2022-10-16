<?php

declare(strict_types=1);

namespace Post\CommandModel;

enum ExceptionReference: String
{
    case INVALID_POST = 'INVALID_POST';
    case INVALID_TEXT = 'INVALID_TEXT';
    case INVALID_UUID = 'INVALID_UUID';
    case INVALID_TIMESTAMP = 'INVALID_TIMESTAMP';  
    case MAX_LIMIT_REACHED = 'MAX_LIMIT_REACHED';
}