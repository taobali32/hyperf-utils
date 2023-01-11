<?php

namespace Jtar\Utils\Event;

class SmsSendBeforeEvent
{
    public array $inputData;

    public function __construct(array $inputData)
    {
        $this->inputData = $inputData;
    }
}