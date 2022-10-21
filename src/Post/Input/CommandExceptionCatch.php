<?php

declare(strict_types=1);

namespace Post\Input;

use Parse\Input\ExceptionContent;
use Post\CommandModel\ExceptionReference;
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
            ExceptionReference::INVALID_TICKET->value,
            ExceptionReference::INVALID_CHRONOLOGY->value,
            ExceptionReference::INVALID_CREATED_AT->value,
            ExceptionReference::INVALID_TIMESTAMP->value => HttpCode::INTERNAL_SERVER_ERROR_500,
            
            ExceptionReference::INVALID_JSON_FORMAT->value => HttpCode::BAD_REQUEST_400->value,

            ExceptionReference::INVALID_UUID->value,
            ExceptionReference::REPOST_OF_REPOST->value,
            ExceptionReference::QUOTE_OF_QUOTE->value,
            ExceptionReference::INVALID_TEXT->value,
            ExceptionReference::POST_LIMIT_REACHED->value,
            ExceptionReference::INVALID_JSON_SCHEMA->value,
            ExceptionReference::INVALID_TARGET_ID->value => HttpCode::UNPROCESSABLE_ENTITY_422->value,
            default => HttpCode::INTERNAL_SERVER_ERROR_500
        };
    }
}
