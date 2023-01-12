<?php

namespace Jtar\Utils\Exception;

use Throwable;

class HttpHandleException  extends \RuntimeException
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}