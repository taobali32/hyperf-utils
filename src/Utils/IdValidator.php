<?php

namespace Jtar\Utils\Utils;
use Jxlwqq\IdValidator\IdValidator as AAA;

/**
 * @see https://github.com/jxlwqq/id-validator
 */
class IdValidator
{
    /**
     * @see https://github.com/jxlwqq/id-validator#%E9%AA%8C%E8%AF%81%E8%BA%AB%E4%BB%BD%E8%AF%81%E5%8F%B7%E5%90%88%E6%B3%95%E6%80%A7
     * 验证身份证号合法性
     * @param $idcard
     * @return bool
     */
    public function isValid($idcard): bool
    {
        $idValidator = new AAA();
        return $idValidator->isValid($idcard);
    }

    /**
     * 获取身份证号信息
     * @see https://github.com/jxlwqq/id-validator#%E8%8E%B7%E5%8F%96%E8%BA%AB%E4%BB%BD%E8%AF%81%E5%8F%B7%E4%BF%A1%E6%81%AF
     * @param $idcard
     * @return bool|array
     * [
            'addressCode'   => '440308',                    // 地址码
            'abandoned'     => 0,                           // 地址码是否废弃，1 为废弃的，0 为正在使用的
            'address'       => '广东省深圳市盐田区',           // 地址
            'addressTree'   => ['广东省', '深圳市', '盐田区'], // 省市区三级列表
            'birthdayCode'  => '1999-01-10',                // 出生日期
            'constellation' => '水瓶座',                     // 星座
            'chineseZodiac' => '卯兔',                       // 生肖
            'sex'           => 1,                           // 性别，1 为男性，0 为女性
            'length'        => 18,                          // 号码长度
            'checkBit'      => '2',                         // 校验码
        ]
     */
    public function getInfo($idcard): bool|array
    {
        $idValidator = new AAA();
        return $idValidator->getInfo($idcard);
    }

    /**
     * 生成可通过校验的假数据
     * @return void
     */
    public function fake(){
        //  see https://github.com/jxlwqq/id-validator#%E7%94%9F%E6%88%90%E5%8F%AF%E9%80%9A%E8%BF%87%E6%A0%A1%E9%AA%8C%E7%9A%84%E5%81%87%E6%95%B0%E6%8D%AE
    }
}