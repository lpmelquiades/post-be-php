<?php

declare(strict_types=1);

namespace Post\Input;

enum HttpCode: int
{
    case NOT_FOUND_404 = 404;
}
