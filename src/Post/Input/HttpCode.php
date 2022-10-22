<?php

declare(strict_types=1);

namespace Post\Input;

enum HttpCode: int
{
    case OK_200 = 200;
    case CREATED_201 = 201;
    case BAD_REQUEST_400 = 400;
    case UNPROCESSABLE_ENTITY_422 = 422;
    case INTERNAL_SERVER_ERROR_500 = 500;
    case BAD_GATEWAY_502 = 502;
    case NOT_FOUND_404 = 404;
}
