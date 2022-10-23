<?php

declare(strict_types=1);

namespace Post\Input;

use Post\Command\QuoteCommand;
use Post\Command\QuoteHandler;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\LoadPort;
use Post\CommandModel\PersistencePort;
use Post\CommandModel\Text;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//Supports [RQ-09]-[RQ-10]-[RQ-15]
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
        $h->handle($this->quote($payload));
        return $response->withStatus(HttpCode::CREATED_201->value);
    }

    private function quote(string $payload): QuoteCommand
    {
        $arr = json_decode($payload, true);
        if ($arr === null) {
            throw new \LogicException(ExceptionReference::INVALID_JSON_FORMAT->value);
        }
        
        if (!isset($arr['username'])) {
            throw new \LogicException(ExceptionReference::INVALID_JSON_SCHEMA->value);
        }

        if (!isset($arr['text'])) {
            throw new \LogicException(ExceptionReference::INVALID_JSON_SCHEMA->value);
        }

        if (!isset($arr['target_id'])) {
            throw new \LogicException(ExceptionReference::INVALID_JSON_SCHEMA->value);
        }

        return new QuoteCommand(
            new Uuid($arr['target_id']),
            new UserName($arr['username']),
            new Text($arr['text'])
        );
    }

}
