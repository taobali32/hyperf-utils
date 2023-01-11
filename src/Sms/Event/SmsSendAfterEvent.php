<?php

namespace Jtar\Utils\Sms\Event;

class SmsSendAfterEvent
{
    public bool $result = false;

    public string $message;
}