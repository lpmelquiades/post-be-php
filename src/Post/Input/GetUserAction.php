<?php

declare(strict_types=1);

namespace Post\Input;

use Post\QueryModel\QueryPort;
use Post\QueryModel\UserName;
use Post\QueryModel\Users;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetUserAction
{
    public function __construct(
        private QueryPort $query
    ){
    }

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
