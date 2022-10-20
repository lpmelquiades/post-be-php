<?php

declare(strict_types=1);

namespace Post\Input;

use Post\Command\Quote;
use Post\Command\QuoteCommand;
use Post\Command\QuoteHandler;
use Post\CommandModel\LoadPort;
use Post\CommandModel\PersistencePort;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class QuoteAction
{
    public function __construct(
        private LoadPort $load,
        private PersistencePort $persistence
    ){
    }

    public function __invoke(Request $request, Response $response)
    {
        $payload = $request->getBody()->getContents();
        $h = new QuoteHandler($this->load, $this->persistence);
        $h->handle(QuoteCommand::build($payload));
        return $response;
    }
}
