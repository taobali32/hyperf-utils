<?php

namespace Jtar\Utils\Abstracts;

use Hyperf\Config\Annotation\Value;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class AbstractRedis
{
    /**
     * 缓存前缀
     */
    #[Value("cache.default.prefix")]
    protected string $prefix;

    /**
     * key 类型名
     */
    protected string $typeName;

    /**
     * 获取实例
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getInstance()
    {
        return jtarApp()->get(static::class);
    }

    /**
     * 获取redis实例
     */
    public function redis()
    {
        return jtarGetRedis();
    }

    /**
     * 获取key
     * @param string $key
     * @return string|null
     */
    public function getKey(string $key): ?string
    {
        return empty($key) ? null : ($this->prefix . trim($this->typeName, ':') . ':' . $key);
    }

}