<?php

declare(strict_types=1);

namespace Post\QueryModel;

enum ExceptionReference: String
{
    case INVALID_QUERY = 'INVALID_QUERY';
}