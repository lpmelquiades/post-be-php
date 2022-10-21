<?php

declare(strict_types=1);

namespace Post\Input;

use Post\Input\HttpCode;
use Psr\Log\LogLevel;

class ExceptionContent
{
    const EXCEPTION_REFERENCE_LINK = 'link_to_some_api_reference';

    public readonly string $responseBody;

    public readonly string $logLevel;
    public readonly array $logContext;
    public readonly string $logMessage;

    public function __construct(
        public readonly HttpCode $httpCode,
        \Throwable $e
    ) {
        $this->logLevel = $this->matchLogLevel($this->httpCode);
        $this->logMessage = $this->getLogMessage($this->httpCode, $e);
        $this->logContext = $this->getContext($e);
        $this->responseBody = $this->getBody($e);
    }

    private function getBody(\Throwable $e): string
    {
        $context = $this->getContext($e);
        unset($context['trace']);
        return json_encode($context, JSON_UNESCAPED_SLASHES);
    }

    private function getContext(\Throwable $e): array
    {
        $context = [
            'error_message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace(),
            'api_reference_link' => static::EXCEPTION_REFERENCE_LINK
        ];

        if ($context['code'] === 0) {
            unset($context['code']);
        }

        return $context;
    }

    private function getLogMessage(HttpCode $httpCode, \Throwable $e): string
    {
        return ($httpCode->value === HttpCode::INTERNAL_SERVER_ERROR_500->value)
            ? 'unexpected_error'
            : strtolower($e->getMessage());
    }

    private function matchLogLevel(HttpCode $code): string
    {
        return match ($code->value) {
            HttpCode::BAD_REQUEST_400->value,
            HttpCode::UNPROCESSABLE_ENTITY_422->value,
            HttpCode::BAD_GATEWAY_502->value,
            HttpCode::INTERNAL_SERVER_ERROR_500->value => LogLevel::CRITICAL,
            default => LogLevel::WARNING
        };
    }
}
