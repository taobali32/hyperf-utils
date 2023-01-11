<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Han\Utils;

use Carbon\Carbon;
use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;
use Psr\EventDispatcher\EventDispatcherInterface;
use Hyperf\HttpServer\Contract\RequestInterface;


/**
 * Finds an entry of the container by its identifier and returns it.
 * @param null|string $id
 * @return mixed|\Psr\Container\ContainerInterface
 */

function jtarApp($id = null)
{
    $container = ApplicationContext::getContainer();
    if ($id) {
        return $container->get($id);
    }

    return $container;
}

function jtarGetRedis(): Redis
{
    return jtarApp()->get(Redis::class);
}

function jtarStrToArr($str, $fen_ge_fu = ",",$unique = true): array
{
    $arr = explode($fen_ge_fu,$str);

    if ($unique == false) return $arr;

    $arr = array_unique($arr);
    if ($unique) return array_filter($arr);

    return $arr;
}

/**
 * 获取2位数字
 * @param $number
 * @param $length
 * @return string
 */
function jtarGetDoubleNumber($number, $length = 2): string
{
    return bcadd($number, (string)0, $length);
}

function jtarJsonToArr($json)
{
    return json_decode($json, true);
}

function jtarArrToStr($arr, $fen_ge_fu = ","): string
{
    return implode($fen_ge_fu, $arr);
}

function jtarArrToJson($arr): bool|string
{
    return json_encode($arr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * 字符串是否包含中文
 * @param $str
 * @return bool
 */
function jtarHasZh($str): bool
{
    $str = urldecode($str);
    if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $str) > 0) {
        return true;
    } else {
        return false;
    }
}

//  获取文件后缀
function jtarGetFileName($uri): string
{
    return substr(strrchr($uri, "/"), 1);
}


//  开头是否是http
function jtarIsStartHttp($link): bool
{
    if (preg_match('|^https*://|', $link) === 0) {
        return false;
    }

    return true;
}

function jtarAddPrefix($uri,$prefix)
{
    if (jtarIsStartHttp($uri)) return $uri;

    return $prefix . $uri;
}

/**
 * 格式化大小
 * @param int $size
 * @return string
 */
function jtarFormatSize(int $size): string
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    $index = 0;
    for ($i = 0; $size >= 1024 && $i < 5; $i++) {
        $size /= 1024;
        $index = $i;
    }
    return round($size, 2) . $units[$index];
}

function jtarContextSet($key,$value = ''){
    return (bool)\Hyperf\Context\Context::set($key, $value);
}

function jtarContextGet($key,$default = null){
    return (bool)\Hyperf\Context\Context::get($key, $default);
}

/**
 * 根据起点坐标和终点坐标测距离
 * @param  [array]   $from 	[起点坐标(经纬度),例如:array(118.012951,36.810024)]
 * @param  [array]   $to 	[终点坐标(经纬度)]
 * @param  [bool]    $km        是否以公里为单位 false:米 true:公里(千米)
 * @param  [int]     $decimal   精度 保留小数位数
 * @return [string]  距离数值
 */
function jtarGetdistance($from,$to,$km=true,$decimal=2){
    sort($from);
    sort($to);
    $EARTH_RADIUS = 6370.996; // 地球半径系数

    $distance = $EARTH_RADIUS*2*asin(sqrt(pow(sin( ($from[0]*pi()/180-$to[0]*pi()/180)/2),2)+cos($from[0]*pi()/180)*cos($to[0]*pi()/180)* pow(sin( ($from[1]*pi()/180-$to[1]*pi()/180)/2),2)))*1000;

    if($km){
        $distance = $distance / 1000;
    }

    return round($distance, $decimal);
}

function jtarEvent(object $dispatch): object
{
    //EventDispatcherInterface
    return jtarApp()->get(EventDispatcherInterface::class)->dispatch($dispatch);
}

//  获取缓存前缀
function jtarGetCachePrefix($name){
    return env('APP_NAME') . '_' . env('APP_ENV') . '_' . $name;
}

/**
 * 获得定单号
 *
 * @return string
 */
function jtarGetOrderId()
{
    $no = jtarApp()->get(\Hyperf\Snowflake\IdGeneratorInterface::class)->generate();

    $no = date('Ymd') . $no;

    return $no;
}


function jtarGetCode($length = 4)
{
    $key = '';
    for ($i = 0; $i < $length; ++$i) {
        $randcode = mt_rand(0, 9);     //指定为数字

        $key .= $randcode;
    }
    return $key;
}

function jtarHidePhone($phone){
    return substr_replace($phone, '****', 3, 4);
}

function jtarCheckPhone($phone)
{
    $chars = "/^1[345678]\d{9}$/";

    if (preg_match($chars, $phone)) {
        return true;
    } else {
        return false;
    }
}

/**
 * ip转地区
 * @param $ip
 * @return array|string
 */
function jtarIpToRegion( $ip){
    $ip2Region = make(Ip2Region::class);
    if (empty($ip2Region->btreeSearch($ip)['region'])) {
        return '未知';
    }
    $region = $ip2Region->btreeSearch($ip)['region'];
    list($country, $number, $province, $city, $network) = explode('|', $region);
    if ($country == '中国') {
        return [
            'province'   =>  $province,
            'city'      =>  $city,
            'network'   =>  $network
        ];
    } else if ($country == '0') {
        return [];
    } else {
        return [];
    }
}

function jtarGetIp()
{
    $request = make(RequestInterface::class);

    $headers = $request->getHeaders();

    $ip = $request->getServerParams()['remote_addr'] ?? '0.0.0.0';

    if (isset($headers['x-real-ip'])) {
        $ip = $headers['x-real-ip'][0];
    } else if (isset($headers['x-forwarded-for'])) {
        $ip = $headers['x-forwarded-for'][0];
    } else if (isset($headers['http_x_forwarded_for'])) {
        $ip = $headers['http_x_forwarded_for'][0];
    }

    return $ip;
}

/**
 * 保留指定小数长度,不舍去
 * @param $num
 * @param $wei
 * @return string
 */
function jtarSprintf2($num, $wei = 1)
{
    $nn = sprintf("%.{$wei}f", $num);

    return $nn;
}

/**
 * build http参数
 * @param $baseUrl
 * @param $params
 * @return mixed|string
 */
function jtarBuildRequestParam($baseUrl, $params)
{
    if(empty($params))
        return $baseUrl;

    $baseUrl .= "?";
    $demo = 0;
    foreach($params as $k=>$v)
    {
        if($demo==0)
        {
            $baseUrl .= "{$k}={$v}";
        }
        else
        {
            $baseUrl .= "&{$k}={$v}";
        }
        $demo++;
    }
    return trim($baseUrl, "&");
}

//  二维数组隐藏掉某一项返回
\Hyperf\Utils\Collection::macro('moreArrayForget',function ($forget){

    $data = [];
    foreach ($this->items as $k => $v){
        $data[] = collect($v)->forget($forget)->all();
    }

    return $data;
});

/**
 * 判断字符串是否由数字和字母的组合而成
 * @param $string
 */
function jtarStrHasStringAndNumber($string){
    if(!preg_match("/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i",$string)){
        return false;
    }

    return true;
}

/**
 * 数字转阿拉伯文字
 * @param $num
 */
function jtarGetNumberToZh($num = 0)
{
    $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
    $chiUni = array('','十', '百', '千', '万', '亿', '十', '百', '千');

    $chiStr = '';

    $num_str = (string)$num;

    $count = strlen($num_str);
    $last_flag = true; //上一个 是否为0
    $zero_flag = true; //是否第一个
    $temp_num = null; //临时数字

    $chiStr = '';//拼接结果
    if ($count == 2) {//两位数
        $temp_num = $num_str[0];
        $chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num].$chiUni[1];
        $temp_num = $num_str[1];
        $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
    }else if($count > 2){
        $index = 0;
        for ($i=$count-1; $i >= 0 ; $i--) {
            $temp_num = $num_str[$i];
            if ($temp_num == 0) {
                if (!$zero_flag && !$last_flag ) {
                    $chiStr = $chiNum[$temp_num]. $chiStr;
                    $last_flag = true;
                }
            }else{
                $chiStr = $chiNum[$temp_num].$chiUni[$index%9] .$chiStr;

                $zero_flag = false;
                $last_flag = false;
            }
            $index ++;
        }
    }else{
        $chiStr = $chiNum[$num_str[0]];
    }

    return $chiStr;
}