<?php

declare(strict_types=1);

namespace Post\Integration;

use Post\CommandModel\LoadPort;
use Post\CommandModel\PostType;
use Post\CommandModel\UserName;
use Post\CommandModel\Timestamp;
use Post\CommandModel\Ticket;
use Post\CommandModel\TicketsInUse;
use Post\CommandModel\Uuid;

class MongoLoadAdapter implements LoadPort
{
    public function __construct(
        public readonly \MongoDB\Client $client
    ) {
    }

    public function ticketsInUse(UserName $userName, Timestamp $begin, Timestamp $end): TicketsInUse
    {
        $postColl = $this->client->selectCollection('post_db', 'post');
        $cursor = $postColl->find(  
            [
                'user_name' => $userName->value,
                'ticket_begin' => $begin->value,
                'ticket_end' => $end->value
            ],
            ['sort' => ['ticket_count' => 1]]
        );

        $postsBson = [];
        foreach ($cursor as $c) {
            $postsBson[] = $c;
        }

        $postsJson = \MongoDB\BSON\toJSON(\MongoDB\BSON\fromPHP($postsBson));
        $postsArr = json_decode($postsJson, true);

        $tickets =  new TicketsInUse($userName, $begin, $end);
        foreach ($postsArr as $post) {
            $tickets->add(
                new Ticket(
                    new UserName($post['user_name']),
                    new Timestamp($post['ticket_begin']),
                    new Timestamp($post['ticket_end']),
                    $post['ticket_count']
                )
            );
        }

        return $tickets;
    }

    public function postType(Uuid $id): ?PostType
    {
        $postColl = $this->client->selectCollection('post_db', 'post');
        $result = $postColl->findOne(['id' => $id->value]);
        return PostType::tryFrom($result['type']);
    }
}
