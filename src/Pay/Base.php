<?php

namespace Jtar\Utils\Pay;

trait Base
{
    public function getWecahtPayMoney($money)
    {
        if (env('APP_ENV') == 'dev'){
            return 1;
        }

        $money = (int)bcmul($money, 100,0);
        return $money;
    }

    public function getAliapyPayMoney($money)
    {
        if (env('APP_ENV') == 'dev'){
            return 0.01;
        }

        return $money;
    }
}