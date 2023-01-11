<?php

namespace Jtar\Utils\Sms\Event;

class SmsSendBeforeEvent
{
    public array $inputData;

    public function __construct(array $inputData)
    {
        $this->inputData = $inputData;
    }
}