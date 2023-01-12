<?php

namespace Jtar\Utils\Abstracts;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Hyperf\HttpServer\Contract\RequestInterface;
use Jtar\Utils\Annotation\Resubmit;
use Jtar\Utils\Exception\HttpHandleException;
use Jtar\Utils\Utils\LockRedis;

/**
 * Class ResubmitAspect
 */
#[Aspect]
class ResubmitAspect extends AbstractAspect
{
    public array $annotations = [
        Resubmit::class
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     * @throws \Throwable
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        /** @var $resubmit Resubmit*/
        if (isset($proceedingJoinPoint->getAnnotationMetadata()->method[Resubmit::class])) {
            $resubmit = $proceedingJoinPoint->getAnnotationMetadata()->method[Resubmit::class];
        }


        $request = jtarApp()->get(RequestInterface::class);

        $key = md5(sprintf('%s-%s-%s', jtarGetIp(), $request->getPathInfo(), $request->getMethod()));

        $lockRedis = new LockRedis();
        $lockRedis->setTypeName('resubmit');

        if ($lockRedis->check($key)) {
            $lockRedis = null;
            throw new HttpHandleException('访问太频繁，请稍后访问');
        }

        $lockRedis->lock($key, $resubmit->second);
        $lockRedis = null;

        return $proceedingJoinPoint->process();
    }
}