<?php

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Fairy\Poster;

ini_set('display_errors',1);
require '../vendor/autoload.php';

$writer = new PngWriter();

$reg_addrss = "https://www.baidu.com/register?code=123456";

$qrCode = QrCode::create($reg_addrss)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(0)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

$result = $writer->write($qrCode);

$post_background = "https://shiyan-1314057598.cos.ap-nanjing.myqcloud.com/bizhi.jpg";

$poster = new Poster($post_background);

$url = "data:image/png;base64,";
$d[] = $url . $poster
        ->image($result->getString(), 220, 970, 300, 300)
//                ->text($user->id, 35, 360, 890, '150, 151, 255')
        ->output('a.png',1);

var_dump($d);

// cv in show  https://tool.jisuapi.com/base642pic.html