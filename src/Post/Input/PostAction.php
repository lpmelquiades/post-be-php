<?php

declare(strict_types=1);

namespace Post\Input;

use Post\Command\PostCommand;
use Post\Command\PostHandler;
use Post\CommandModel\ExceptionReference;
use Post\CommandModel\LoadPort;
use Post\CommandModel\PersistencePort;
use Post\CommandModel\Text;
use Post\CommandModel\UserName;
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
        $h->handle($this->post($payload));
        return $response->withStatus(HttpCode::CREATED_201->value);
    }

    private function post(string $payload): PostCommand
    {
        $arr = json_decode($payload, true);
        if ($arr === null) {
            throw new \LogicException(ExceptionReference::INVALID_JSON_FORMAT->value);
        }

        if (!isset($arr['username']) || !isset($arr['text'])) {
            throw new \LogicException(ExceptionReference::INVALID_JSON_SCHEMA->value);
        }

        return new PostCommand(
            new UserName($arr['username']),
            new Text($arr['text'])     
        );
    }

}
