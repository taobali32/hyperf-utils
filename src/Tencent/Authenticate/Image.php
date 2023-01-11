<?php

namespace Jtar\Utils\Tencent\Authenticate;

use Jtar\Utils\Exception\InvalidArgumentException;
use Qcloud\Cos\Client;

/**
 * @see https://cloud.tencent.com/document/product/436/45434
    图片文件大小支持：支持审核32MB以下的图片。对于大小超过5MB的图片，您需要在调用请求时，使用 large-image-detect 参数。。
    图片文件分辨率支持：建议分辨率大于256x256，否则可能会影响识别效果。
    图片文件支持格式：PNG、JPG、JPEG、BMP、GIF、WEBP 格式。
    图片文件链接支持的传输协议：HTTP、HTTPS。
    调用接口需携带签名，具体规则请参见 请求签名 文档。
 */
class Image
{
    protected string $region;
    protected string $secretId;
    protected string $secretKey;
    protected string $bucket;
    protected string $appid;
    protected string $biz_type;
    protected int $async;
    protected string $callback;

    /**
     * @param $region
     * @param $secretId
     * @param $secretKey
     */
    public function __construct($region, $secretId, $secretKey,$bucket,$appid,$biz_type,$async = 0,$callback = '')
    {
        $this->region = $region;
        $this->secretId = $secretId;
        $this->secretKey = $secretKey;
        $this->bucket = $bucket;
        $this->appid = $appid;
        $this->biz_type = $biz_type;

        $this->async = $async;
        $this->callback = $callback;
    }

    /**
     * @param $image
     * @param bool $source  是否返回源数据
     * @param string $dataid    图片标识，该字段在结果中返回原始内容，长度限制为512字节。
     * @return bool|object
     */
    public function check($image,$source = false,$dataid = '')
    {

        if (empty($image)) throw new InvalidArgumentException();

        $cosClient = new Client(
            array(
                'region' => $this->region,
                'schema' => 'https', // 审核时必须为https
                'credentials' => array(
                    'secretId' => $this->secretId,
                    'secretKey' => $this->secretKey)));

        $conf = [
            'Bucket' => $this->bucket . '-' . $this->appid,
            'Key' => '/', // 链接图片资源路径写 / 即可
            'ci-process' => 'sensitive-content-recognition',
            'DetectUrl' => $image,
            'Async' => $this->async,
            //  对于超过大小限制的图片是否进行压缩后再审核，取值为： 0（不压缩），1（压缩）。
            //  默认为0。注：压缩最大支持32MB的图片，且会收取图片压缩费用。对于 GIF 等动态图过大时，压缩时间较长，可能会导致审核超时失败。
            'LargeImageDetect'    =>  1,
            'large-image-detect'    =>  1,
            'dataid'    =>  $dataid,
            'DataId'    =>  $dataid,
            'bizType'   =>  $this->biz_type,
        ];
        if ($this->callback) $conf['Callback'] = $this->callback;

        $result = $cosClient->detectImage($conf);

        if ($source) return $result;

        if ($result['Result'] == 0) return true;

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

        $result = $cosClient->getDetectImageResult(array(
            'Bucket' => $this->bucket . '-' . $this->appid, //存储桶名称，由BucketName-Appid 组成，可以在COS控制台查看 https://console.cloud.tencent.com/cos5/bucket
            'Key' => $jobId,
        ));

        if ($source) return $result;

        if ($result['Result'] == 0) return true;

        return false;
    }
}