<?php

use Jtar\Utils\Tencent\Authenticate\Text;

ini_set('display_errors',1);


require '../vendor/autoload.php';
require '../src/Tencent/Authenticate/Text.php';

$region = "ap-nanjing";
$secretId = "AKIDEbu00vgw33AMSRWXdYGuS6ZrvmXEl9Uu";
$secretKey = "RmEc3KbvCO7l171mXLCwdHpGgzISPBl8";
$bucket = "shiyan";
$appid = "1314057598";
$biz_type = "16736d4766bf05a2c9f54642e256fbd6";


$service = new Text($region, $secretId, $secretKey, $bucket, $appid, $biz_type);

//  st1196ea3c91c211eda2ea525400e8647b
//var_dump($service->check('你麻痹',false));

var_dump($service->query('st1196ea3c91c211eda2ea525400e8647b'));

