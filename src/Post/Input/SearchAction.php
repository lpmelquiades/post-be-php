<?php

declare(strict_types=1);

namespace Post\Input;

use Post\Query\Search;
use Post\QueryModel\QueryPort;
use Post\QueryModel\Timestamp;
use Post\QueryModel\UserName;
use Post\QueryModel\UserNames;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/** 
 *  Supports [RQ-01]-[RQ-02]-[RQ-03].
 *  Relates api input with search query.
 */
class SearchAction
{
    public function __construct(
        private QueryPort $query
    ){
    }

    public function __invoke(Request $request, Response $response)
    {
        $uriQuery = $request->getUri()->getQuery();
        $result = $this->query->search($this->search($uriQuery));
        $response->getBody()->write(json_encode($result));
        return $response;
    }

    private function search(string $uriQuery): Search
    {
        parse_str($uriQuery, $arr);
        $userNames = new UserNames();
        if (isset($arr['users'])) {
            foreach ($arr['users'] as $u) {
                $userNames->add(new UserName($u));
            }
        }

        return new Search(
            $userNames,
            isset($arr['begin']) ? new Timestamp($arr['begin']): null,
            isset($arr['end']) ? new Timestamp($arr['end']): null,
            isset($arr['page_size']) ? intval($arr['page_size']): 10,
            isset($arr['page']) ? intval($arr['page']): 1    
        );
    }
}
