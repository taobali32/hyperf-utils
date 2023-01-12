<?php
ini_set('display_errors',1);
require '../vendor/autoload.php';

use Hyperf\HttpServer\Contract\RequestInterface;
use Jtar\Utils\Pay\Wechat\BasePay;
use EasyWeChat\Pay\Message;


class aa{
    use BasePay;

    protected array $provides = [
        'hf_wechat_h5'  =>  WechatPay::class,
        'hf_alipay_h5'  =>  AlipayPay::class,

        'df_wechat_h5'  =>  \UserSide\Service\Pay\H5\Df\WechatPay::class
    ];

    public function pay1(){
        $app = $this->getWechatApp('','','','','','');

        $response = $app->getClient()->post('/v3/pay/transactions/h5', [
            'json' => [
                "mchid"         =>  '',
                "out_trade_no"  => '',
                "appid"         =>  '',
                "description"   =>  "订单支付",
                "attach"        =>  "df_wechat_h5",
                "notify_url"    =>  env("PAY_WECHAT_CALL_BACK"),
                "amount"    =>  [
                    "total" =>  $this->getWecahtPayMoney(0),
                    "currency"  =>  "CNY"
                ],
                "scene_info"    =>  [
                    "payer_client_ip"   =>  jtarGetIp(),
                    "h5_info"   =>  [
                        "type"  =>  "Wap"
                    ]
                ]
            ]
        ]);

        return $response->toArray(false);
    }


    public function callback(){

        $app = $this->getWechatApp('','','','','','');

        $app->setRequest(make(RequestInterface::class));
        $server = $app->getServer();

        $server->handlePaid(function (Message $message, \Closure $next) {

            $service = new $this->provides[$message->attach];
            $service->callBack($message);
            return $next($message);
        });

        return $server->serve();
    }


    /*
     * @see https://easywechat.com/6.x/pay/server.html
     */
    public function callBack22($message)
    {
        Db::beginTransaction();

        try {
            $order = DfOrder::query()->where('pay_no',$message->out_trade_no)
                ->where('status',0)
                ->lockForUpdate()
                ->first();

            if ($order){
                $this->after($order,$message->transaction_id);
            }
            Db::commit();

        }catch (\Exception $exception){
            Db::rollBack();
        }
    }

    public function after($order,$transaction_id): void
    {
        $order->update(['status' => 1,'pay_at' => Carbon::now()->toDateTimeString(),'call_no' => $transaction_id]);
        DfOrderLog::ins($order->id,'订单支付成功');

        $find = DfHistoryAccount::query()->where('account',$order->account)->first();

        if (empty($find)){
            DfHistoryAccount::query()->create([
                'user_id'    =>  $order->user_id,
                'account'    =>  $order->account,
                'prov'  =>  $find->prov,
                'city'  =>  $find->city,
                'account_id'    =>  $order->account_id
            ]);
        }

    }``
}


