<?php

declare(strict_types=1);

namespace Post\Integration;
use Post\Query\Search;
use Post\QueryModel\QueryPort;

class MongoQueryAdapter implements QueryPort
{
    public function __construct(
        public readonly \MongoDB\Client $client
    ) {
    }

    public function search(Search $s): array
    {
        $postColl = $this->client->selectCollection('post_db', 'post');
        $match =  $this->buildMatch($s);
        $pipeline = $this->buildPipe($s);
        $cursor = $postColl->aggregate(  
            array_merge($match, $pipeline)
        );
        return $this->extract($cursor);
    }

    private function extract($cursor): array
    {
        $postsBson = [];
        foreach ($cursor as $c) {
            $postsBson = $c->all;
        }

        $postsJson = \MongoDB\BSON\toJSON(\MongoDB\BSON\fromPHP($postsBson));
        $postsArr = json_decode($postsJson, true);
        return array_map(function ($post) {
            unset($post['_id']);
            return $post;
        }, $postsArr);
    }

    private function buildMatch(Search $s): array
    {
        $expArr = [];
        if ($s->userNames->count() !== 0) {
            $expArr = [['$in' => ['$user_name', $s->userNames->toArray()]]];
        }

        if ($s->begin !== null) {
            $expArr[] = ['$gte' => [['$toDate' => '$created_at'], ['$toDate' => $s->begin->value]]];
        }
        if ($s->end !== null) {
            $expArr[] = ['$lte' => [['$toDate' => '$created_at'], ['$toDate' => $s->end->value], ]];
        }
        return $expArr === [] ? [] : [['$match' => ['$expr' => ['$and' => $expArr]]]];
    }

    private function buildPipe(Search $s): array
    {
        return [
            [ '$sort' => [ 'created_at' => -1]],
            [ '$group' => [
                '_id' => null,
                'all' =>  [ '$push' => '$$ROOT' ]
            ]],
            ['$project' => [ 
                'all' => [ '$slice' =>  [ 
                    '$all', 
                    ($s->page-1)*$s->pageSize,
                    $s->pageSize ]
                ]
            ]]
        ];
    }
}
