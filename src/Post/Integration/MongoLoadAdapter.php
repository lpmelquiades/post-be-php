<?php

declare(strict_types=1);

namespace Post\Integration;

use Post\CommandModel\ExceptionReference;
use Post\CommandModel\LoadPort;
use Post\CommandModel\Now;
use Post\CommandModel\PostType;
use Post\CommandModel\UserName;
use Post\CommandModel\Timestamp;
use Post\CommandModel\Ticket;
use Post\CommandModel\TicketsInUse;
use Post\CommandModel\Uuid;
use User\QueryModel\UserName as QueryModelUserName;
use User\QueryModel\Users;

class MongoLoadAdapter implements LoadPort
{
    public function __construct(
        public readonly \MongoDB\Client $client
    ) {
    }

    /** Supports [RQ-11].
    * Now and TicketsInUse are required to get the next persistence ticket for a post.
    * This feature is enforced in the database with unique index contraints
    * !!IMPORTANT!! That a look in the database init file at ./local/mongo/init.js
    */
    public function ticketsInUse(UserName $userName, Now $now): TicketsInUse
    {
        $postColl = $this->client->selectCollection('post_db', 'post');
        $cursor = $postColl->find( 
            $this->getFilter($userName, $now), 
            ['sort' => ['ticket_count' => 1]]
        );

        $postsBson = [];
        foreach ($cursor as $c) {
            $postsBson[] = $c;
        }

        $postsJson = \MongoDB\BSON\toJSON(\MongoDB\BSON\fromPHP($postsBson));
        $postsArr = json_decode($postsJson, true);

        $tickets =  new TicketsInUse($userName, $now);
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

    private function getFilter(UserName $userName, Now $now): array
    {
        return[
            'user_name' => $userName->value,
            'ticket_begin' => $now->timestamp->beginningOfDay()->value,
            'ticket_end' => $now->timestamp->beginningOfTomorrow()->value,
        ];
    }

    public function postType(Uuid $id): PostType
    {
        $postColl = $this->client->selectCollection('post_db', 'post');
        $result = $postColl->findOne(['id' => $id->value]);
        
        if ($result === null) {
            throw new \LogicException(ExceptionReference::INVALID_TARGET_ID->value);
        }

        if (!isset($result['type']))
        {
            throw new \LogicException(ExceptionReference::INVALID_TARGET_ID->value);
        }

        if(PostType::tryFrom($result['type']) === null)
        {
            throw new \LogicException(ExceptionReference::INVALID_TARGET_ID->value);
        }

        return PostType::from($result['type']);
    }

    // Supports [RQ-07]-[RQ-09]
    public function isValidUser(UserName $userName): bool
    {
        return (new Users())->get(new QueryModelUserName($userName->value)) !== [];
    }
}
