<?php

declare(strict_types=1);

namespace Post\Input;

use Post\Command\PostCommand;
use Post\Command\PostHandler;
use Post\CommandModel\LoadPort;
use Post\CommandModel\PersistencePort;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostAction
{
    public function __construct(
        private LoadPort $load,
        private PersistencePort $persistence
    ){
    }

    public function __invoke(Request $request, Response $response)
    {
        $payload = $request->getBody()->getContents();
        $h = new PostHandler($this->load, $this->persistence);
        $h->handle(PostCommand::build($payload));
        return $response->withStatus(HttpCode::CREATED_201->value);
    }
}
