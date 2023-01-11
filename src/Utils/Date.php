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
namespace Jtar\Utils\Utils;

use Carbon\Carbon;

class Date
{
    /**
     * @param null|int|string $date
     */
    public function load($date): ?Carbon
    {
        if (is_numeric($date)) {
            return Carbon::createFromTimestamp($date);
        }

        return Carbon::make($date);
    }

    /**
     * 本周每天开始/结束时间
     */
    public function getThisWeekDay($timestamp = false): array
    {
        $date = [];

        for ($i = 0; $i < 6; $i++){
            $start = Carbon::now()->startOfWeek()->addDays($i);
            $end = Carbon::now()->startOfWeek()->addDays($i)->endOfDay();
            $temp = [
                'start' => $timestamp ? $start->timestamp : $start->toDateTimeString(),
                'end'   =>  $timestamp ? $end->timestamp : $end->toDateTimeString()
            ];

            $date[] = $temp;
        }

        return $date;
    }

    /**
     * 上个月第一天
     * @return Carbon
     */
    public function lastMonthStart(): Carbon
    {
        return Carbon::now()->subMonth()->firstOfMonth();
    }

    /**
     * 上个月最后一天
     * @return Carbon
     */
    public function lastMonthEnd(): Carbon
    {
        return Carbon::now()->subMonth()->lastOfMonth();
    }

    /**
     * 当前月第一天
     * @return Carbon
     */
    public function thisMonthStart(): Carbon
    {
       return  Carbon::now()->firstOfMonth();
    }

    /**
     * 当前月最后一天
     * @return Carbon
     */
    public function thisMonthEnd(): Carbon
    {
        return  Carbon::now()->endOfMonth();
    }

    /**
     * 某个月有多少天
     * @param $year
     * @param $month
     * @return string
     */
    public function monthDays($year = null,$month = null): string
    {
        if ($year == null) $year = Carbon::now()->year;
        if ($month == null) $month = Carbon::now()->month;

        return date("t",strtotime("$year-$month"));
    }

    /**
     * 明天开始时间
     * @return string
     */
    public function tomorrowStart(): string
    {
        return  Carbon::tomorrow()->startOfDay()->toDateTimeString();
    }

    /**
     * 明天开始时间
     * @return string
     */
    public function tomorrowEnd(): string
    {
        return  Carbon::tomorrow()->endOfDay()->toDateTimeString();
    }

    /**
     * 时间差计算
     * @param $time
     * @param bool $absolute 是否返回>0数字
     */
    public function diffInSeconds($time,$absolute = true,$rtn = 'second')
    {
        $time = Carbon::parse($time);

        switch ($rtn){
            case 'second':
                return (new Carbon())->diffInSeconds($time,$absolute);
            case 'minute':
                return (new Carbon())->diffInMinutes($time,$absolute);
            case 'hour':
                return (new Carbon())->diffInHours($time,$absolute);
            case 'hour_float':
                return (new Carbon())->floatDiffInRealHours($time,$absolute);
            case 'day':
                return (new Carbon())->diffInDays($time,$absolute);
            case 'month':
                return (new Carbon())->diffInMonths($time,$absolute);
            case 'year':
                return (new Carbon())->diffInYears($time,$absolute);
        }
    }

    /**
     * 时间比较
     * @param $time1
     * @param $op
     * @param $time2
     * @return mixed
     */
    public function compareDate($time1,$op = '>',$time2 = '')
    {
        if ($time2 == '') $time2 = Carbon::now()->toDateTimeString();

        $method = [
            '>'     =>  'gt',
            '>='    =>  'gte',
            '<'     =>  'lt',
            '<='    =>  'lte'
        ];

        return Carbon::parse($time1)->{$method[$op]}(Carbon::parse($time2));
    }

    /**
     * 日期转换为想要的格式
     * @param $time
     * @param $format
     * @return string
     */
    public function format($time,$format = 'Y/m/d H:i:s'){
        return Carbon::parse($time)->format($format);
    }

    /**
     * 昨天开始时间
     * @return string
     */
    public function yesterdayStart(): string
    {
        return  Carbon::parse('yesterday')->toDateTimeString();
    }

    /**
     * 昨天结束时间
     * @return string
     */
    public function yesterdayEnd(): string
    {
        return  Carbon::parse('yesterday')->endOfDay()->toDateTimeString();
    }

    /**
     * n天前后现在的时间
     * @param $day
     * @return string
     */
    public function nDay($day = 1): string
    {
        return Carbon::parse("+{$day} days")->toDateTimeString();
    }

    /**
     * n周前后现在的时间
     * @param $week
     * @return string
     */
    public function nWeek($week = 1): string
    {
        return Carbon::parse("+{$week} weeks")->toDateTimeString();
    }

    /**
     * n月前后现在的时间
     * @param $month
     * @return string
     */
    public function nMonth($month = 1): string
    {
        return Carbon::parse("+{$month} months")->toDateTimeString();
    }

    /**
     * n月前后现在的时间
     * @param $year
     * @return string
     */
    public function nYear($year = 1): string
    {
        return Carbon::parse("+{$year} years")->toDateTimeString();
    }


    /**
     * 下周某天开始时间, 注意要传递比周天-1的数字
     */
    public function nextWeekStartN($days = 1): string
    {
        return Carbon::parse("+1 weeks")->startOfWeek()->addDays($days)->toDateTimeString();
    }
    /**
     * 下周某天技术时间, 注意要传递比周天-1的数字
     */
    public function nextWeekEndN($days = 1): string
    {
        return Carbon::parse("+1 weeks")->startOfWeek()->addDays($days)->endOfDay()->toDateTimeString();
    }

    public function between($time1,$time2){
        return Carbon::parse($time1)->between($time2[0], $time2[1]);
    }

    /**
     * 时间转为周几
     * @param $time
     * @return int
     */
    public function timeToWeek($time)
    {
        return Carbon::createFromTimestamp($time)->dayOfWeek;
    }

    /**
     * 获取某个月每天开始和结束时间
     * @param $month
     * @return array
     */
    public  function getMonthDays($month,$timestamp = false): array
    {
        $arr = [];

        $endMonth = Carbon::parse($month)->endOfMonth()->toDateTimeString();

        $i = 0;

        while (Carbon::parse($endMonth)->gte(Carbon::parse($month)->startOfMonth()->addDays($i)->endOfDay()->toDateTimeString() ) ){

            if ($timestamp == false){
                $t = [
                    Carbon::parse($month)->startOfMonth()->addDays($i)->toDateTimeString(),
                    Carbon::parse($month)->startOfMonth()->addDays($i)->endOfDay()->toDateTimeString(),
                    Carbon::parse($month)->startOfMonth()->addDays($i)->toDateString()
                ];
            }else{
                $t = [
                    Carbon::parse($month)->startOfMonth()->addDays($i)->timestamp,
                    Carbon::parse($month)->startOfMonth()->addDays($i)->endOfDay()->timestamp,
                    Carbon::parse($month)->startOfMonth()->addDays($i)->toDateString()
                ];
            }


            $arr[] = $t;

            $i++;
        }

        return $arr;
    }

    /**
     * 获取某天每个小时开始和结束时间
     * @param $at
     * @return array
     */
    public  function getDayHours($at,$timestamp = false): array
    {
        $hours = [];

        for ($i = 0; $i < 24; $i++){
            if ($timestamp == false){
                $temp = [
                    Carbon::parse($at)->startOfDay()->hours($i)->addMinutes(0)->addSeconds(0)->toDateTimeString(),
                    Carbon::parse($at)->startOfDay()->hours($i)->addMinutes(59)->addSeconds(59)->toDateTimeString(),
                    sprintf("%02d", $i)
                ];
            }else{
                $temp = [
                    Carbon::parse($at)->startOfDay()->hours($i)->addMinutes(0)->addSeconds(0)->timestamp,
                    Carbon::parse($at)->startOfDay()->hours($i)->addMinutes(59)->addSeconds(59)->timestamp,
                    sprintf("%02d", $i)
                ];
            }

            $hours[] = $temp;
        }

        return $hours;
    }
}
