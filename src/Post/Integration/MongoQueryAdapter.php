<?php

declare(strict_types=1);

namespace Post\Integration;

use Post\Query\Count;
use Post\Query\Search;
use Post\QueryModel\QueryPort;
use Post\QueryModel\Timestamp;
use Post\QueryModel\UserNames;

class MongoQueryAdapter implements QueryPort
{
    public function __construct(
        public readonly \MongoDB\Client $client
    ) {
    }

    public function count(Count $s): array
    {
        $postColl = $this->client->selectCollection('post_db', 'post');
        $match = $this->buildMatch($s->userNames, $s->begin, $s->end);
        $cursor = $postColl->aggregate(
            array_merge(
                $match,
                [ 
                    ['$group' => [
                        '_id' => null,
                        'count' =>  [ '$sum' => 1 ]
                    ]]
                ]
            )
        );
        $bson = ['count' => 0];
        foreach($cursor as $c) {
            $bson = $c;
        }
        $json = \MongoDB\BSON\toJSON(\MongoDB\BSON\fromPHP($bson));
        $arr = json_decode($json, true);
        unset($arr['_id']);
        return $arr;
    }

    public function search(Search $s): array
    {
        $postColl = $this->client->selectCollection('post_db', 'post');
        $match =  $this->buildMatch($s->userNames, $s->begin, $s->end);
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

    private function buildMatch(UserNames $userNames, ?Timestamp $begin, ?Timestamp $end): array
    {
        $expArr = [];
        if ($userNames->count() !== 0) {
            $expArr = [['$in' => ['$user_name', $userNames->toArray()]]];
        }

        if ($begin !== null) {
            $expArr[] = ['$gte' => [['$toDate' => '$created_at'], ['$toDate' => $begin->value]]];
        }
        if ($end !== null) {
            $expArr[] = ['$lte' => [['$toDate' => '$created_at'], ['$toDate' => $end->value], ]];
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
