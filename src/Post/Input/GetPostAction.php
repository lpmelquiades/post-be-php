<?php

declare(strict_types=1);

namespace Post\Input;

use Post\QueryModel\QueryPort;
use Post\QueryModel\Uuid;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetPostAction
{
    public function __construct(
        private QueryPort $query
    ){
    }

    public function __invoke(Request $request, Response $response, $id)
    {
        $result = $this->query->getPost(new Uuid($id));
        $response->getBody()->write(json_encode($result));
        return $response;
    }
}
