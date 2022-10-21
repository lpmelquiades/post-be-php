<?php

declare(strict_types=1);

namespace Post\Input;

use Parse\Input\ExceptionContent;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as ResquestHandler;
use Slim\Psr7\Response;

class CommandExceptionCatch implements MiddlewareInterface
{

    public function __construct(
        private \Psr\Log\LoggerInterface $logger
    ) {
    }

    public function process(Request $request, ResquestHandler $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            $content = new ExceptionContent($this->matchHttpCode($e), $e);

            $this->logger->log(
                $content->logLevel,
                $content->logMessage,
                $content->logContext
            );

            $response = new Response();
            $response->getBody()->write($content->responseBody);
            return $response->withStatus($content->httpCode->value);
        };
    }

    private function matchHttpCode(\Throwable $e): HttpCode
    {
        return match ($e->getMessage()) {
            ExceptionReference::INVALID_JSON_FORMAT->value => HttpCode::BAD_REQUEST_400,
            ExceptionReference::INVALID_DATA_ID_KEY->value,
            ExceptionReference::INVALID_DATA_ID->value,
            ExceptionReference::INVALID_JSON_SCHEMA->value,
            ExceptionReference::INVALID_PROVIDER->value => HttpCode::UNPROCESSABLE_ENTITY_422,
            ExceptionReference::PERSISTENCE_FAILURE->value => HttpCode::BAD_GATEWAY_502,
            default => HttpCode::INTERNAL_SERVER_ERROR_500
        };
    }
}
