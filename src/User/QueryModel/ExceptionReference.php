<?php

declare(strict_types=1);

namespace User\QueryModel;

enum ExceptionReference: String
{
    case INVALID_USERNAME = 'INVALID_USERNAME';
}