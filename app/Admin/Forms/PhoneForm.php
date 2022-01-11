<?php

namespace App\Admin\Forms;


use App\Events\PhoneEvent;

use App\Models\Assetsrecord;
use App\Models\Balance;
use App\Models\Myorderlist;

use App\Models\Phoneorder;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Form\NestedForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PhoneForm extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
//         dump($input);
         if(empty($input)){
             return $this
                 ->response()
                 ->error('提交数据为空')
                 ->refresh();
         }
         $user=Admin::user();
         $user->append('balance');
         $user->balance=Balance::where('uid',$user->id)->value('balance');
         $errordata=[];
         foreach ($input['phone'] as $k=>$v){
                sleep(1);
                $orderstatus=$this->orderIn($v,$user);
//                dd($orderstatus);
                if(!$orderstatus['code']){
                    $errordata[$k]=$orderstatus['data'];
                }
         }

        if(empty($errordata)){
            return $this
                ->response()
                ->success('处理成功')
                ->refresh();
        }else{
            foreach ($errordata as $k=>$v){
                $this->errIn($v);
            }
            return $this
                ->response()
                ->error('有未完成的没有提交')
                ->redirect('myorderlist');
        }


    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->table('phone','话费充值', function (NestedForm $table) {
            $table->text('account','手机号')->rules('required|regex:/^\d+$/|min:10|max:13',[
                'regex'=>'户号必须是数字',
                'min'=>'户号不得少于10位',
                'max'=>'户号不得多于13位',
            ]);
            $table->select('type','充值类型')
              ->options(['fast_call'=>'快充','slow_call'=>'慢充'])
              ->default('slow_call')
              ->required();
            $table->select('amount','金额')
                ->options([
                    200=>200
                ])
                ->width(300)
                ->placeholder('请选择充值金额')
                ->required();
//            $table->text('desc','备注名')->placeholder('例如：张三或者 0001   0002');
        });
        $this->confirm('确定内容没有错误吗？');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'name'  => 'John Doe',
            'email' => 'John.Doe@gmail.com',
        ];
    }
    public function orderIn($data,$user)
    {

        //订单入库
        DB::beginTransaction();
        $ordermodel=new Phoneorder();
//        $shop=Shop::find($data['amount']);
        $userzk=Balance::where('uid',$user->id)->value('phone_par');
        $sysorderid=Str::random(4).time().'sdht';

        $ordermodel->uid=$user['id'];
        $ordermodel->orderid=$sysorderid;
        $ordermodel->u_order_id=$sysorderid;
        $ordermodel->phone=$data['account'];
        $ordermodel->type=$data['type'];
        $ordermodel->source=2;
        $ordermodel->pid=$user['pid'];
        $ordermodel->order_price=$data['amount'];
        $ordermodel->notify='';
        $ordermodel->kk_amount=($userzk*$data['amount'])/100;//商品价格*用户折扣/100
//        $ordermodel->shop_id=1;
        $phone = json_decode(file_get_contents("https://cx.shouji.360.cn/phonearea.php?number=".$data['account']),1)["data"];
        if(empty($phone)){
            $ordermodel->resmsg='号码识别失败';
            DB::commit();
            return ['code'=>false,'data'=>$ordermodel->toArray()];
        }
        $ordermodel->province=$phone['city'];
        $ordermodel->city=$phone['province'];
        $ordermodel->sp=$phone['sp'];
        if($userzk==0){
            $ordermodel->resmsg='折扣未设置';
            DB::commit();
            return ['code'=>false,'data'=>$ordermodel->toArray()];
        }
        if($user->balance<$ordermodel->kk_amount){
            $ordermodel->resmsg='余额不足';
            DB::commit();
            return ['code'=>false,'data'=>$ordermodel->toArray()];
        }
        $asses=new Assetsrecord();
        $asses->uid=$user['id'];
        $asses->before=Balance::where('uid',$user['id'])->value('balance');
        $asses->balance=$ordermodel->kk_amount;
        $userkk=Balance::whereUid($user['id'])->decrement('balance',$ordermodel->kk_amount);

        $asses->type=2;
        $asses->aid=$user['id'];
        $asses->orderid=$sysorderid;
        $asses->xftype=3;//消费扣款
        $asses->role=2;
        $asses->after=Balance::where('uid',$user['id'])->value('balance');
        if($ordermodel->save() && $userkk && $asses->save()){
            Log::channel('reapi')->info('手工充值入库',['订单数据'=>$ordermodel->toArray(),'入库结果'=>'入库成功']);
            DB::commit();
//            event(new PhoneEvent($ordermodel));
            return ['code'=>true,'data'=>$ordermodel->toArray()];
        }else{
            Log::channel('reapi')->info('手工充值入库',['订单数据'=>$ordermodel->toArray(),'入库结果'=>'入库失败']);
            DB::rollBack();
            return ['code'=>false,'data'=>$ordermodel->toArray()];
        }
    }

    /***
     * 充值失败记录
     * @param $data
     * @return bool
     */
    public function errIn($data)
    {
        $myorderlist=new Myorderlist();
        $myorderlist->orderid=$data['orderid'];
//        $myorderlist->province_name=\App\Models\Powerprovince::where('power_id',$data['province'])->value('province_name');;
        $myorderlist->acco=$data['phone'];
        $myorderlist->amount=$data['order_price'];
        $myorderlist->kk_amount=$data['kk_amount'];
        $myorderlist->msg=$data['resmsg'];
        $myorderlist->status=0;
        $myorderlist->type=2;
        $s=$myorderlist->save();
        if($s){
            return true;
        }else{
            return false;
        }
    }
}
