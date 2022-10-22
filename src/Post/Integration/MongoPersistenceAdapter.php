<?php

declare(strict_types=1);

namespace Post\Integration;

use Post\CommandModel\NextPost;
use Post\CommandModel\PersistencePort;

class MongoPersistenceAdapter implements PersistencePort
{
    public function __construct(
        public readonly \MongoDB\Client $client
    ) {
    }

    public function save(NextPost $next): void
    {
        $format =  new PostDbFormat();
        $postColl = $this->client->selectCollection('post_db', 'post');
        
        $postColl->insertOne($format->post($next->post));
    }
}
