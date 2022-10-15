<?php

declare(strict_types=1);

namespace Post\CommandModel;

enum ExceptionReference: String
{
    case MAX_LIMIT_REACHED = 'MAX_LIMIT_REACHED';
    case INVALID_TEXT = 'INVALID_TEXT';
    case INVALID_UUID = 'INVALID_UUID';
    case INVALID_TIMESTAMP = 'INVALID_TIMESTAMP';  
}