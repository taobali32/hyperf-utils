<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Jtar\Utils;

use EasyTree\Adapter\Handler\ArrayAdapter;
use Qcloud\Cos\Client;


class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                    'class_map' => [
                        Client::class => __DIR__ . '/ClassMap/Client.php',
                        ArrayAdapter::class => __DIR__ . '/ClassMap/ArrayAdapter.php',
                    ],
                ],
            ],
        ];
    }
}
