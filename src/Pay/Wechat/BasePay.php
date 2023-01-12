<?php

namespace Jtar\Utils\Pay\Wechat;

use Jtar\Utils\Pay\Base;
use EasyWeChat\Pay\Application;

trait BasePay
{
    use Base;

    public function getWechatApp($app_id,$mach_id,$private_key,$certificate,$secret_key,$v2_secret_key): Application
    {
        $config = [
            'app_id'    =>  $app_id,
            'mch_id' => $mach_id,

            // 商户证书
            'private_key' => $private_key,
            'certificate' => $certificate,

            // v3 API 秘钥
            'secret_key' => $secret_key,

            // v2 API 秘钥
            'v2_secret_key' => $v2_secret_key,

            // 平台证书：微信支付 APIv3 平台证书，需要使用工具下载
            // 下载工具：https://github.com/wechatpay-apiv3/CertificateDownloader
            'platform_certs' => [
                // '/path/to/wechatpay/cert.pem',
            ],
            /**
             * 接口请求相关配置，超时时间等，具体可用参数请参考：
             * https://github.com/symfony/symfony/blob/5.3/src/Symfony/Contracts/HttpClient/HttpClientInterface.php
             */
            'http' => [
                'throw'  => true, // 状态码非 200、300 时是否抛出异常，默认为开启
                'timeout' => 5.0,
                // 'base_uri' => 'https://api.mch.weixin.qq.com/', // 如果你在国外想要覆盖默认的 url 的时候才使用，根据不同的模块配置不同的 uri
            ],
        ];

        return new Application($config);
    }
}