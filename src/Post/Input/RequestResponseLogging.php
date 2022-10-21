<?php

declare(strict_types=1);

namespace Post\Input;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as ResquestHandler;
use Slim\Psr7\Response;

class RequestResponseLogging implements MiddlewareInterface
{
    public function __construct(
        private \Psr\Log\LoggerInterface $logger
    ) {
    }

    public function process(Request $request, ResquestHandler $handler): ResponseInterface
    {
        $this->logger->info('request', $this->getRequestContent($request));
        $response = $handler->handle($request);
        $this->logger->info('response', $this->getResponseContent($response));
        return $response;
    }

    private function getRequestContent(Request $request): array
    {
        return [
            'method' => $request->getMethod(),
            'url' => (string) $request->getUri(),
            'headers' => $request->getHeaders(),
            'parsed_content' => json_decode($request->getBody()->getContents(), true),
            'content' => $request->getBody()->getContents()
        ];
    }

    private function getResponseContent(Response $response): array
    {
        return [
            'status' => $response->getStatuscode(),
            'headers' => $response->getHeaders(),
            'content' => json_decode((string) $response->getBody(), true)
        ];
    }
}
