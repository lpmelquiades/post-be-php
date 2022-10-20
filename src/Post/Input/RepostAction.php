<?php

declare(strict_types=1);

namespace Post\Input;

use Post\Command\RepostCommand;
use Post\Command\RepostHandler;
use Post\CommandModel\LoadPort;
use Post\CommandModel\PersistencePort;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RepostAction
{
    public function __construct(
        private LoadPort $load,
        private PersistencePort $persistence
    ){
    }

    public function __invoke(Request $request, Response $response)
    {
        $payload = $request->getBody()->getContents();
        $h = new RepostHandler($this->load, $this->persistence);
        $h->handle(RepostCommand::build($payload));
        return $response;
    }
}
