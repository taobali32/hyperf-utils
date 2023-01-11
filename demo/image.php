<?php

use Jtar\Utils\Tencent\Authenticate\Image;
use Jtar\Utils\Tencent\Authenticate\Text;

ini_set('display_errors',1);


require '../vendor/autoload.php';
require '../src/Tencent/Authenticate/Text.php';

$region = "ap-nanjing";
$secretId = "AKIDEbu00vgw33AMSRWXdYGuS6ZrvmXEl9Uu";
$secretKey = "RmEc3KbvCO7l171mXLCwdHpGgzISPBl8";
$bucket = "shiyan";
$appid = "1314057598";
$biz_type = "aac1ea601170bb557fbf3c451bbd9c62";


$service = new Image($region, $secretId, $secretKey, $bucket, $appid, $biz_type);

//  st1196ea3c91c211eda2ea525400e8647b
$uri = "https://shiyan-1314057598.cos.ap-nanjing.myqcloud.com/1376.jpg_wh300.jpg";
//var_dump($service->check($uri,true));

var_dump($service->query('si545ccdbb91cd11eda9475254008a7ac8',false));

