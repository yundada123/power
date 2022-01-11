<?php

namespace App\Http\Controllers;

use App\Events\PowerEvent;
use App\Events\SendHttpMessageEvent;
use App\Models\Assetsrecord;
use App\Models\Balance;
use App\Models\Order;
use App\Models\User;
use Dcat\Admin\Support\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutoApiController extends Controller
{

    public function index(Request $request)
    {
        //订单入库
        DB::beginTransaction();
        $ordermodel=new Order();
        $sysorderid='sdht'.time().'sdht';
        $ordermodel->user_id=$request->user['id'];
        $ordermodel->orderid=$sysorderid;
        $ordermodel->u_order_id=$request->orderid;
        $ordermodel->acco=$request->account;
        $ordermodel->type=1;
        $ordermodel->source=1;
        $ordermodel->pid=$request->user['pid'];
        $ordermodel->order_price=$request->shop['shop_price'];
        $ordermodel->notify=$request->notify;
        $ordermodel->kk_amount=($request->shop['shop_price']*$request->user['power_par'])/100;//商品价格*用户折扣/100
        $ordermodel->shop_id=$request->shop['id'];
        $ordermodel->province=$request->province;

        $userkk=Balance::whereUid($request->user['id'])->decrement('balance',$ordermodel->kk_amount);

        $asses=new Assetsrecord();
        $asses->uid=$request->user['id'];
        $asses->before=$request->user['amount'];
        $asses->balance=$ordermodel->kk_amount;
        $asses->type=2;
        $asses->aid=$request->user['id'];
        $asses->orderid=$sysorderid;
        $asses->xftype=3;//消费扣款
        $asses->role=2;
        $asses->after=Balance::whereUid($request->user['id'])->value('balance');
        if($ordermodel->save() && $userkk && $asses->save()){
            Log::channel('reapi')->info('订单入库',['订单数据'=>$ordermodel->toArray(),'入库结果'=>'入库成功']);
            DB::commit();
            event(new PowerEvent($ordermodel));
            return Helper::json_msg(200, '订单提交成功',[
                'sys_order_id'=>$sysorderid,
                'user_order_id'=>$request->orderid,
                'time'=>time()
            ]);
        }else{
            Log::channel('reapi')->info('订单入库',['订单数据'=>$ordermodel->toArray(),'入库结果'=>'入库失败']);
            DB::rollBack();
            return Helper::json_msg(201, '订单提交失败');
        }
    }

    public function dfnotify(Request $request)
    {
        // echo 22222;
        // Log::info('电费回调2', [$request->all()]);
        // echo 123;
        // exit;
//        sleep(1);
        $post = $request->all();
        if(empty($post)){
            $post=$request->getContent();
            $post=json_decode($post,1);
        }
        Log::channel('api')->info('电费回调', [$request->all()]);
        if (empty($post['sign'])) {
            Log::channel('api')->info('电费回调没有sign');
            return 'error';
        }
        $sign = $post['sign'];
        unset($post['sign']);
        $data = [
            'order_id' => $post['order_id'],
            'out_order_id' => $post['out_order_id'],
            'mchid' => $post['mchid'],
            'account' => $post['account'],
            'price' => $post['price'],
            'status' => $post['status']
        ];
        $mySign = $this->getDianfeiSign($data);
        if ($mySign == $sign) {
            $order=Order::where('orderid',$data['order_id'])->first();
            if($order->status==1 && $data['status'] == 1){//充值成功
                $order->status=3;
                //推送消息
                event(new SendHttpMessageEvent($order));
                $order->save();
                DB::commit();
                Log::channel('api')->info('电费充值接口', ['orderid' => $order->orderid, '数据保存'=>'成功']);
            }elseif($order->status==1 && $data['status'] != 1){//充值失败
                $order->status=4;
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
                    //推送消息
                    event(new SendHttpMessageEvent($order));
                    DB::commit();
                    Log::channel('api')->info('电费充值接口', ['orderid' => $order->orderid, '数据保存'=>'成功']);
                }else{
                    DB::rollBack();
                    Log::channel('api')->info('电费充值接口', ['orderid' => $order->orderid, '数据保存'=>'失败']);
                }
            }
            echo 'success';
        }else{
            echo 'error';
        }
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
