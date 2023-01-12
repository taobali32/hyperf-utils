<?php

namespace Jtar\Utils\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Jtar\Utils\Utils\HttpCode;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class HttpHandleException extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $format = [
            'success' => false,
            'message' => $throwable->getMessage(),
            'code'    => HttpCode::VALIDATE_FAILED,
        ];

        return $response->withHeader('Server', 'Api')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus(200)->withBody(new SwooleStream(Json::encode($format)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof \Jtar\Utils\Exception\HttpHandleException;
    }
}