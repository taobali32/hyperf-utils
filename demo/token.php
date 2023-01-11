<?php

use Jtar\Utils\Tencent\Authenticate\Image;
use Jtar\Utils\Tencent\Cloud\Token;

ini_set('display_errors',1);


require '../vendor/autoload.php';
require '../src/Tencent/Cloud/Token.php';


$token = new Token();



var_dump($token->get($secretId, $secretKey, $bucket, $appid, $region));
