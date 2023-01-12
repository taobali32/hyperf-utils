<?php

namespace Jtar\Utils\Utils;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Request;

class JtarRequest extends Request
{

    #[Inject]
    protected JtarResponse $response;


    /**
     * 获取协议架构
     * @return string
     */
    public function getScheme(): string
    {
        if (isset($this->getHeader('X-scheme')[0])) {
            return $this->getHeader('X-scheme')[0].'://';
        } else {
            return 'http://';
        }
    }
}

