<?php

namespace Jtar\Utils\Exception;

use Hyperf\Server\Exception\ServerException;
use Throwable;

class HttpHandleException  extends ServerException
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}