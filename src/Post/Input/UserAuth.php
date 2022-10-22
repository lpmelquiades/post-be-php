<?php

declare(strict_types=1);

namespace Post\Input;

use Post\QueryModel\UserName;
use Post\QueryModel\Users;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as ResquestHandler;
use Slim\Psr7\Response;

class UserAuth implements MiddlewareInterface
{
    public function process(Request $request, ResquestHandler $handler): ResponseInterface
    {
        $payload = $request->getBody()->getContents();
        $arr = json_decode($payload, true);
        $users = new Users();
        if (
            $arr === null || !isset($arr['username'])
            || $users->get(new UserName($arr['username'])) === []
        ) {
            $response = new Response();
            return $response->withStatus(HttpCode::UNAUTHORIZED_401->value);
        }
        
        return $handler->handle($request);
    }
}
