<?php

declare(strict_types=1);

namespace Post\CommandModel;

enum ExceptionReference: String
{
    case INVALID_POST = 'INVALID_POST';
    case INVALID_TICKET = 'INVALID_TICKET';
    case UNFIT_FOR_SEGMENT_USERNAME = 'UNFIT_FOR_SEGMENT_USERNAME';
    case UNFIT_FOR_SEGMENT_DURATION = 'UNFIT_FOR_SEGMENT_DURATION';
    case INVALID_JSON_FORMAT = 'INVALID_JSON_FORMAT';
    case INVALID_REPOST = 'INVALID_REPOST';
    case REPOST_OF_REPOST = 'REPOST_OF_REPOST';
    case QUOTE_OF_QUOTE = 'QUOTE_OF_QUOTE';
    case INVALID_QUOTE = 'INVALID_QUOTE';
    case INVALID_TEXT = 'INVALID_TEXT';
    case INVALID_UUID = 'INVALID_UUID';
    case INVALID_TIMESTAMP = 'INVALID_TIMESTAMP';  
    case POST_LIMIT_REACHED = 'POST_LIMIT_REACHED';
    case INVALID_JSON_SCHEMA = 'INVALID_JSON_SCHEMA';
    case INVALID_TARGET_ID = 'INVALID_TARGET_ID';

}