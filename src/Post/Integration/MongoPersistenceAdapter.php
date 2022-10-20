<?php

declare(strict_types=1);

namespace Post\Integration;

use Post\CommandModel\PersistencePort;
use Post\CommandModel\Post;

class MongoPersistenceAdapter implements PersistencePort
{
    public function __construct(
        public readonly \MongoDB\Client $client
    ) {
    }

    public function save(Post $post): void
    {
        $postColl = $this->client->selectCollection('post_db', 'post');
        $postColl->insertOne($post->toArray());
    }
}
