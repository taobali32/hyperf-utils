<?php

use Jtar\Utils\Tencent\Authenticate\Image;
use Jtar\Utils\Tencent\Authenticate\Text;

ini_set('display_errors',1);


require '../vendor/autoload.php';
require '../src/Tencent/Authenticate/Text.php';




$service = new Image($region, $secretId, $secretKey, $bucket, $appid, $biz_type);

//  st1196ea3c91c211eda2ea525400e8647b
$uri = "https://shiyan-1314057598.cos.ap-nanjing.myqcloud.com/1376.jpg_wh300.jpg";
//var_dump($service->check($uri,true));

var_dump($service->query('si74de84bc91cc11ed94095254005c26d0',false));

