<?php

namespace Jtar\Utils\Annotation;

use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;


/**
 * 禁止重复提交
 * @Annotation
 * @Target({"METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD)]
class Resubmit extends AbstractAnnotation
{
    /**
     * second
     * @var int
     */
    public int $second = 3;


    public function __construct($value = 3)
    {
        parent::__construct($value);
        $this->bindMainProperty('second', [ $value ]);
    }
}