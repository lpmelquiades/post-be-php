<?php

declare(strict_types=1);

namespace User\Input;

use Post\Input\HttpCode;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use User\QueryModel\UserName;
use User\QueryModel\Users;

// Supports [RQ-05]. Relates api input with users model
class GetUserAction
{

    public function __invoke(Request $request, Response $response, $username)
    {
        $result = (new Users())->get(new UserName($username));
        if($result === []){
            return $response->withStatus(HttpCode::NOT_FOUND_404->value);   
        }
        $response->getBody()->write(json_encode($result));
        return $response;
    }
}
