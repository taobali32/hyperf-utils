<?php

namespace Jtar\Utils\Tencent\Cloud;

use QCloud\COSSTS\Sts;

class Token
{
    public function get($secretId,$secretKey,$bucket,$app_id,$region,$allowPrefix = '*',$durationSeconds = 1800){
        $sts = new Sts();
        $config = array(
            'url' => 'https://sts.tencentcloudapi.com/',
            'domain' => 'sts.tencentcloudapi.com',
            'proxy' => '',
            'secretId' => $secretId, // 固定密钥
            'secretKey' => $secretKey, // 固定密钥
            'bucket' => $bucket . '-' . $app_id, // 换成你的 bucket
            'region' => $region, // 换成 bucket 所在园区
            'durationSeconds' => $durationSeconds, // 密钥有效期
            // 允许操作（上传）的对象前缀，可以根据自己网站的用户登录态判断允许上传的目录，例子： user1/* 或者 * 或者a.jpg
            // 请注意当使用 * 时，可能存在安全风险，详情请参阅：https://cloud.tencent.com/document/product/436/40265
//            'allowPrefix' => '_ALLOW_DIR_/*',
            'allowPrefix' => $allowPrefix,
            // 密钥的权限列表。简单上传和分片需要以下的权限，其他权限列表请看 https://cloud.tencent.com/document/product/436/31923
            'allowActions' => array (
                // 所有 action 请看文档 https://cloud.tencent.com/document/product/436/31923
                // 简单上传
                'name/cos:PutObject',
                'name/cos:PostObject',
                // 分片上传
                'name/cos:InitiateMultipartUpload',
                'name/cos:ListMultipartUploads',
                'name/cos:ListParts',
                'name/cos:UploadPart',
                'name/cos:CompleteMultipartUpload'
            )
        );

        // 获取临时密钥，计算签名
        return  $sts->getTempKeys($config);
    }
}