<?php

namespace Jtar\Utils\Tencent\Authenticate;

use Jtar\Utils\Exception\InvalidArgumentException;
use Qcloud\Cos\Client;

/**
 * @see https://cloud.tencent.com/document/product/436/56289
 * 文本内容大小支持：当审核的内容为纯文本信息，需要先经过 base64 编码，文本编码前的原文长度不能超过10000个 utf8 编码字符。
 * 文本文件大小支持：当传入的内容为文本文件时，文件大小不能超过1MB。
 * 文本审核语言支持：目前支持中文、英文、阿拉伯数字的检测。
 */
class Text
{
    protected string $region;
    protected string $secretId;
    protected string $secretKey;
    protected string $bucket;
    protected string $appid;
    protected string $biz_type;

    /**
     * @param $region
     * @param $secretId
     * @param $secretKey
     */
    public function __construct($region, $secretId, $secretKey,$bucket,$appid,$biz_type)
    {
        $this->region = $region;
        $this->secretId = $secretId;
        $this->secretKey = $secretKey;
        $this->bucket = $bucket;
        $this->appid = $appid;
        $this->biz_type = $biz_type;
    }

    /**
     * @param $text
     * @param bool $source 是否返回源数据
     * @return bool|object
     */
    public function check($text,$source = false)
    {
        if (empty($text)) throw new InvalidArgumentException();

        $cosClient = new Client(
            array(
                'region' => $this->region,
                'schema' => 'https', // 审核时必须为https
                'credentials' => array(
                    'secretId' => $this->secretId,
                    'secretKey' => $this->secretKey)));

        $conf = [
            'BizType'   =>  $this->biz_type,
        ];

        $result = $cosClient->detectText(array(
            'Bucket' => $this->bucket . '-' . $this->appid, //存储桶名称，由BucketName-Appid 组成，可以在COS控制台查看 https://console.cloud.tencent.com/cos5/bucket
            'Input' => array(
                'Content' => base64_encode($text) //文本需base64_encode
            ),
            'Conf' => $conf
        ));

        if ($source == true) return $result;

        if ($result['JobsDetail']['Result'] == 0) return true;

        return false;
    }


    public function query($jobId,$source = false)
    {
        $cosClient = new Client(
            array(
                'region' => $this->region,
                'schema' => 'https', // 审核时必须为https
                'credentials'=> array(
                    'secretId'  => $this->secretId ,
                    'secretKey' => $this->secretKey)));

        $result = $cosClient->getDetectTextResult(array(
            'Bucket' => $this->bucket . '-' . $this->appid, //存储桶名称，由BucketName-Appid 组成，可以在COS控制台查看 https://console.cloud.tencent.com/cos5/bucket
            'Key' => $jobId,
        ));

        if ($source == true) return $result;

        if ($result['JobsDetail']['Result'] == 0) return true;

        return false;
    }
}