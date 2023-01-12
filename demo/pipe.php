<?php

use Hyperf\Utils\Pipeline;

ini_set('display_errors',1);

require '../vendor/autoload.php';

interface Pipe
{
    public function handle($body, Closure $next);
}

class JiFenProduct implements Pipe
{
    public function handle($body, Closure $next)
    {
        $price = 0;
        foreach ($body['data'] as $item) {

            if ($item['type'] == 'ji_fen') {
                $product_id = $item['product_id'];

                $product_number = $item['number'];

                $product_price = $item['price'];

                $price += ($product_number * $product_price);
            }

        }
        $body['price'] += $price;
        return $next($body);
    }
}

class NoneProduct implements Pipe
{
    public function handle($body, Closure $next)
    {
        $price = 0;
        foreach ($body['data'] as $item) {

            if ($item['type'] == 'none') {
                $product_id = $item['product_id'];

                $product_number = $item['number'];

                $product_price = $item['price'];

                $price += ($product_number * $product_price);
            }

        }
        $body['price'] += $price;
        return $next($body);
    }
}

class YouHuiQuanProduct implements Pipe
{
    public function handle($body, Closure $next)
    {
        $price = 0;
        foreach ($body['data'] as $item) {

            if ($item['type'] == 'you_hui_quan') {
                $product_id = $item['product_id'];

                $product_number = $item['number'];

                $product_price = $item['price'];

                $price += ($product_number * $product_price);
            }

        }
        $body['price'] += $price;
        return $next($body);
    }
}

$data = [
    [
        'product_id'    =>  1,
        'sku_id'        =>  1,
        'number'        =>  1,
        'price'         =>   1,
        'type'          =>  'none'    //  普通商品没活动
    ],
    [
        'product_id'    =>  2,
        'sku_id'        =>  2,
        'number'        =>  2,
        'price'         =>  2,
        'type'          =>  'ji_fen'    //  积分兑换抵扣
    ],
    [
        'product_id'    =>  3,
        'sku_id'        =>  3,
        'number'        =>  3,
        'price'         =>  3,
        'type'          =>  'you_hui_quan'  //  优惠券
    ]
];

$activity = ['none','ji_fen','you_hui_quan'];

$dd = [];

foreach ($activity as $k => $v){
    foreach ($data as $kk => $vv){
        if ($vv['type'] == $v){
            $dd[$v][] = $vv;
        }
    }
}

$ren = [
    'data' => $data,
    'price' => 0,
];

// 按照顺序执行的
$pipes = [
    JiFenProduct::class,
    NoneProduct::class,
    YouHuiQuanProduct::class
];

//  放在hyperf执行
$result = make(Pipeline::class)
    ->send($ren)
    ->through($pipes)
    ->then(function ($ren) {
        return $ren;
});




var_dump($result['price']); // $result['price'] = 3