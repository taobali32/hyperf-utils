<?php


ini_set('display_errors',1);
require '../vendor/autoload.php';

use EasySwoole\VerifyCode\VerifyCode;
use EasySwoole\VerifyCode\Conf;

$Conf = new Conf();

$Conf->setBackColor('#3A5FCD');
$Conf->setBackColor('CCC');
$Conf->setBackColor([30, 144, 255]);

$VCode = new VerifyCode($Conf);

// 随机生成验证码
$Code = $VCode->DrawCode();

//  获取验证码
var_dump($Code->getImageCode());

//  验证码图片转base64
var_dump($Code->getImageBase64());

//  获取codeHash
var_dump($Code->getCodeHash());

//  给前端返回base64验证码和codeHash,codeHash写入redis指向验证码，设置有效时间

// 前端提交后带着codeHash去验证!

