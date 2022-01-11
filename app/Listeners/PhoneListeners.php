<?php

namespace App\Listeners;

use App\Events\PhoneEvent;
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

class PhoneListeners
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
    public function handle(PhoneEvent $event)
    {
        $order=$event->order;
        $res = $this->sendphone($order);
        DB::beginTransaction();
        Log::channel('api')->info('话费充值接口', ['orderid' => $order->orderid, '接口返回'=>$res]);
        if ($res['code'] == 0) {//提交成功
            $order->status=1;
            $order->porderid=$res['data']['order_id'];
            if($order->save()){
                DB::commit();
                Log::channel('api')->info('话费充值接口', ['orderid' => $order->orderid, '数据保存'=>'成功']);
            }else{
                DB::rollBack();
                Log::channel('api')->info('话费充值接口', ['orderid' => $order->orderid, '数据保存'=>'失败']);
            }
        } else {
            $order->status=2;
            $asses=new Assetsrecord();
            $asses->uid=$order->uid;
            $asses->before=Balance::whereUid($order->uid)->value('balance');;
            $s=Balance::whereUid($order->uid)->increment('balance',$order->kk_amount);//退回商户的钱
            $asses->balance=$order->kk_amount;
            $asses->type=1;
            $asses->aid=1;
            $asses->orderid=$order->orderid;
            $asses->xftype=4;//系统退款
            $asses->role=2;
            $asses->after=Balance::whereUid($order->uid)->value('balance');
            if($s && $order->save() && $asses->save()){
                DB::commit();
                Log::channel('api')->info('话费充值接口', ['orderid' => $order->orderid, '数据保存'=>'成功']);
                event(new SendHttpMessageEvent($order));
            }else{
                DB::rollBack();
                Log::channel('api')->info('话费充值接口', ['orderid' => $order->orderid, '数据保存'=>'失败']);
            }
        }

    }


    /***
     * 充值 api
     * @param $order
     */
    public function sendphone($order)
    {
        $url='http://159.75.230.35/api/order/phone/recharge';
        $apikey='1237d75cb985565a7ca827620f134c54';
        $user='便民102';
        $data['username']=$user;
        $data['mobile']=$order->phone;
        $data['orderNo']=$order->orderid;
        $data['amount']=$order->order_price;
        $data['productType']=$order->type;
        $data['notifyUrl']=url('api/phonenotfiy');
        $data['timestamp']=(string)(time());
        $data['special']=0;
        $data['sign']=strtoupper(md5($data['username'].$data['mobile'].$data['orderNo'].$data['amount'].$data['productType'].$data['notifyUrl'].$data['timestamp'].$apikey));
//        dump($data);
        $res = json_decode(Helper::https_request($url, json_encode($data),array('Content-Type: application/json')), true);
        return $res;
    }
}
