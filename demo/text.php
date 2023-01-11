<?php

use Jtar\Utils\Tencent\Authenticate\Text;

ini_set('display_errors',1);


require '../vendor/autoload.php';
require '../src/Tencent/Authenticate/Text.php';




$service = new Text($region, $secretId, $secretKey, $bucket, $appid, $biz_type);

//  st1196ea3c91c211eda2ea525400e8647b
//var_dump($service->check('你麻痹',false));

var_dump($service->query('st1196ea3c91c211eda2ea525400e8647b'));

