<?php

declare(strict_types=1);

namespace Post\QueryModel;

enum ExceptionReference: String
{
    case INVALID_QUERY = 'INVALID_QUERY';
    case INVALID_UUID = 'INVALID_UUID';
    case INVALID_USERNAME = 'INVALID_USERNAME';
}