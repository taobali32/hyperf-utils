<?php

namespace Jtar\Utils\Sms;
use Hyperf\Guzzle\ClientFactory;
use Jtar\Utils\Sms\Event\SmsSendAfterEvent;
use Jtar\Utils\Sms\Event\SmsSendBeforeEvent;
use function Han\Utils\jtarEvent;

class DuanXinBao
{
    protected $sms_account;
    protected $sms_password;
    protected $sms_sign;

    /**
     * @param $sms_account
     * @param $sms_password
     * @param $sms_sign
     */
    public function __construct($sms_account, $sms_password, $sms_sign = '')
    {
        $this->sms_account = $sms_account;
        $this->sms_password = $sms_password;
        $this->sms_sign = $sms_sign;
    }

    public function send($sendText,$mobile)
    {
        $smsapi = "http://api.smsbao.com/";

        jtarEvent(new SmsSendBeforeEvent(['sendText' => $sendText,'mobile' => $mobile]));
//        event_add($event)
        $statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );

        $config = [
            'sms_account' => $this->sms_account,
            'sms_password' => $this->sms_password,
            'sms_sign' => $this->sms_sign
        ];

        $user = $config['sms_account']; //短信平台帐号
        $pass = md5($config['sms_password']); //短信平台密码

        $sendurl = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $mobile . "&c=" . urlencode($sendText);

        $clientFactory = make(ClientFactory::class);
        $response = $clientFactory->create()->get($sendurl)->getBody();
        $result = json_decode($response, true);

        $after = new SmsSendAfterEvent();
        $after->result = ($result == 0) ? true : false;
        $after->message = $statusStr[$result] ?? '短信发送失败';

        jtarEvent($after);

        if ($result == 0) return true;

        return $statusStr[$result] ?? '短信发送失败';
    }
}