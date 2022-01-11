<?php

namespace App\Listeners;

use App\Events\PowerEvent;
use App\Events\SendHttpMessageEvent;
use App\Models\Assetsrecord;
use App\Models\Balance;
use App\Models\Powerprovince;
use App\Models\User;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Support\Helper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PowerListeners
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PowerEvent  $event
     * @return void
     */
    public function handle(PowerEvent $event)
    {
        $order=$event->order;
        $res = $this->rechargeDfi($order->acco, $order->orderid, $order->order_price, 86400, url('api/dfnotify'), $this->provinceof($order->province));
        DB::beginTransaction();
        Log::channel('api')->info('电费充值接口', ['orderid' => $order->orderid, '接口返回'=>$res]);
        if ($res['code'] == 0) {//提交成功
            $order->status=1;
            $order->p_order_id=$res['order_id'];
            if($order->save()){
                DB::commit();
                Log::channel('api')->info('电费充值接口', ['orderid' => $order->orderid, '数据保存'=>'成功']);
            }else{
                DB::rollBack();
                Log::channel('api')->info('电费充值接口', ['orderid' => $order->orderid, '数据保存'=>'失败']);
            }
        } else {
            $order->status=2;
            $asses=new Assetsrecord();
            $asses->uid=$order->user_id;
            $asses->before=Balance::whereUid($order->user_id)->value('balance');;
            $s=Balance::whereUid($order->user_id)->increment('balance',$order->kk_amount);//退回商户的钱
            $asses->balance=$order->kk_amount;
            $asses->type=1;
            $asses->aid=1;
            $asses->orderid=$order->orderid;
            $asses->xftype=4;//系统退款
            $asses->role=2;
            $asses->after=Balance::whereUid($order->user_id)->value('balance');
            if($s && $order->save() && $asses->save()){
                DB::commit();
                Log::channel('api')->info('电费充值接口', ['orderid' => $order->orderid, '数据保存'=>'成功']);
                event(new SendHttpMessageEvent($order));
            }else{
                DB::rollBack();
                Log::channel('api')->info('电费充值接口', ['orderid' => $order->orderid, '数据保存'=>'失败']);
            }
        }

    }

    public function provinceof($str)
    {
        return Powerprovince::where('power_id',$str)->value('province_name');
    }
    /**
     * 充值电费
     * account 充值号码
     * orderid 订单号
     * price 充值金额
     * timeout 到账范围值，如86400，暂不生效
     * notify 异步回调地址
     * province 省份
     */
    function rechargeDfi($account, $orderid, $price, $timeout, $notify, $province)
    {
        $config = $this->getDianfeiConfig();
        $url = $config['url'] . '/api/power_pay';

        $data = [
            'mchid' => $config['mchid'],
            'account' => $account,
            'price' => $price,
            'orderid' => $orderid,
            'timeout' => $timeout,
            'notify' => $notify,
            'time' => time(),
            'rand' => rand(100000, 999999),
        ];

        $data['sign'] = $this->getDianfeiSign($data);
        $data['province'] = $province;
        $data = json_decode(Helper::https_request($url, $data), true);

        return $data;
    }

    /**
     * 电费接口签名
     */
    function getDianfeiSign($data)
    {
        $config = $this->getDianfeiConfig();
        $string = '';
        foreach ($data as $k => $v) {
            $string .= $v;
        }
        $string .= $config['key'];
        return md5($string);
    }

    /**
     * 电费接口配置
     */
    function getDianfeiConfig()
    {
        return ['mchid' => "20103", 'key' => '5794761a2dbf1bda343fbd820e761b44', 'url' => "http://121.41.5.205"];
    }
}
