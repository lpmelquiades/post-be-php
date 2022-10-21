<?php

declare(strict_types=1);

namespace Post\Input;

use Post\Query\Search;
use Post\Query\SearchHandler;
use Post\QueryModel\QueryPort;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SearchAction
{
    public function __construct(
        private QueryPort $query
    ){
    }

    public function __invoke(Request $request, Response $response)
    {
        $uriQuery = $request->getUri()->getQuery();
        $search = Search::build($uriQuery);
        $h = new SearchHandler($this->query);
        $result = $h->handle($search);
        $response->getBody()->write(json_encode($result));
        return $response;
    }
}
