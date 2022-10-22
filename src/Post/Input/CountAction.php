<?php

declare(strict_types=1);

namespace Post\Input;

use Post\Query\Count;
use Post\QueryModel\QueryPort;
use Post\QueryModel\Timestamp;
use Post\QueryModel\UserName;
use Post\QueryModel\UserNames;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CountAction
{
    public function __construct(
        private QueryPort $query
    ){
    }

    public function __invoke(Request $request, Response $response)
    {
        $uriQuery = $request->getUri()->getQuery();
        $result = $this->query->count($this->count($uriQuery));
        $response->getBody()->write(json_encode($result));
        return $response;
    }

    private function count(string $uriQuery): Count
    {
        parse_str($uriQuery, $arr);
        $userNames = new UserNames();
        if (isset($arr['users'])) {
            foreach ($arr['users'] as $u) {
                $userNames->add(new UserName($u));
            }
        }

        return new Count(
            $userNames,
            isset($arr['begin']) ? new Timestamp($arr['begin']): null,
            isset($arr['end']) ? new Timestamp($arr['end']): null
        );
    }
}
