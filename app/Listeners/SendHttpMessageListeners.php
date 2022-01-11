<?php

namespace App\Listeners;

use App\Events\SendHttpMessageEvent;
use App\Models\User;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Support\Helper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendHttpMessageListeners implements ShouldQueue
{

    public $connection = 'redis';

    /**
     * 任务将被发送到的队列的名称
     *
     * @var string|null
     */
    public $queue = 'SendHttpMessage';
    public $tries = 0;
    /**
     * 任务被处理的延迟时间（秒）
     *
     * @var int
     */
    public $delay = 0;

    /**
     * 获取监听器队列的名称
     *
     * @return string
     */
    public function viaQueue()
    {
        return 'SendHttpMessage';
    }
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
     * @param  SendHttpMessageEvent  $event
     * @return void
     */
    public function handle(SendHttpMessageEvent $event)
    {
        $order=$event->order;
        $user=Administrator::whereId($order->user_id)->first();
        if($order->status==2 || $order->status==4){

            $data=[
                'code'=>201,
                'msg'=>'充值失败',
                'data'=>[
                    'sys_order_id'=>$order->orderid,
                    'user_order_id'=>$order->u_order_id,
                    'time'=>time()
                ],
            ];
            $key = $user->apikey;
            ksort($data);
            $data['sign']= strtoupper(md5(urlencode(http_build_query($data)) . '&key=' . $key));

            $res=Helper::https_request($order->notify,json_encode($data),array('Content-Type: application/json'));
            $order->notify_status=1;
            $order->notify_msg=$res;
        }elseif($order->status==3){
            $data=[
                'code'=>200,
                'msg'=>'充值成功',
                'data'=>[
                    'sys_order_id'=>$order->orderid,
                    'user_order_id'=>$order->u_order_id,
                    'time'=>time()
                ],
            ];
            $key = $user->apikey;
            ksort($data);
            $data['sign']= strtoupper(md5(urlencode(http_build_query($data)) . '&key=' . $key));

            $res=Helper::https_request($order->notify,json_encode($data),array('Content-Type: application/json'));
            $order->notify_status=1;
            $order->notify_msg=$res;
        }
        $order->save();
    }
}
