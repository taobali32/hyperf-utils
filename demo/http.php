<?php

ini_set('display_errors',1);
use Jtar\Utils\Utils\Http;


require '../vendor/autoload.php';
require '../src/Utils/Http.php';

try {

    $http = new Http();

    $uri = "http://web.hf.api.jiabaoleshop.com/api/v1/user_side/hf/get_history_mobile";
    $res = $http->get($uri);

    var_dump(111);
    var_dump($res);
//$http->post($uri);

}catch (Exception $exception){
    var_dump($exception->getMessage());
}