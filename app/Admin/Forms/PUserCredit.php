<?php

namespace App\Admin\Forms;

use App\Models\Assetsrecord;
use App\Models\Balance;
use App\Models\Creditlog;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PUserCredit extends Form
{
    use LazyWidget;
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {

        $id = $this->payload['id'] ?? null;
        $ids=Administrator::find($id);//被授信人
        DB::beginTransaction();
//        $jl=new Assetsrecord();
//        $jl2=new Assetsrecord();
        $sxjl1=new Creditlog();//授信人
        $sxjl2=new Creditlog();//被授信人
        $sxid=Admin::user()->id;//授信人 ID
        $orderid=Str::random(12);
        $sbyue=Balance::whereUid($sxid)->value('balance');//授信人的余额
        if(Admin::user()->inRoles(['agent'])){
            if($input['amount']<100){
                return $this
                    ->response()
                    ->error('授信失败,授信最小额度100')
                    ->refresh();
            }
            if($input['amount']<0){
                return $this
                    ->response()
                    ->error('授信失败,金额错误')
                    ->refresh();
            }
            if($input['amount']>$sbyue){
                return $this
                    ->response()
                    ->error('授信失败,可用额度不足')
                    ->refresh();
            }
        }
        $sbyue2=Balance::whereUid($id)->value('balance');//被授信人的余额
        if($ids){
            $sxjl1->pid=$sxid;
            $sxjl2->pid=$sxid;
            $sxjl1->amount=$input['amount'];
            $sxjl2->amount=$input['amount'];
            $sxjl1->uid=$id;
            $sxjl2->uid=$id;
            $sxjl1->aamount=$sbyue;
            $sxjl2->aamount=$sbyue2;
            $sxjl1->type=1;
            $sxjl2->type=2;
//            $jl->uid=$id;
//            $jl->before=$ids->amount;
//            $jl->balance=$input['amount'];
//            $jl2->uid=$ids->pid;
//            $jl2->before=$sbyue;
//            $jl2->balance=$input['amount'];
//            dd($sxjl1->toArray(),$sxjl2->toArray(),$ids);
            $ss=Balance::where('uid',$id)->increment('balance',$input['amount']);
            $sss=Balance::where('uid',$sxid)->decrement('balance',$input['amount']);
            if($ss && $sss){
                $sxjl1->bamount=Balance::whereUid($sxid)->value('balance');
                $sxjl2->bamount=Balance::whereUid($id)->value('balance');
//                $jl->type=1;
//                $jl->aid=Admin::user()->id;
//                $jl->orderid=$orderid;
//                $jl->xftype=2;//代理授信
//                $jl->role=2;
//                $jl->after=Balance::whereUid($id)->value('balance');
//                $jl2->type=1;
//                $jl2->aid=Admin::user()->id;
//                $jl2->orderid=$orderid;
//                $jl2->xftype=2;//代理授信
//                $jl2->role=1;
//                $jl2->after=Balance::whereUid($ids->pid)->value('balance');
//                if($jl->save() && $jl2->save() && $sxjl1->save() && $sxjl2->save()){
                if($sxjl1->save() && $sxjl2->save()){
                    DB::commit();
                }else{
                    DB::rollBack();
                    Log::channel('asses')->info('给商户授信',['uid'=>$id,'amount'=>$input['amount'],'time'=>now()->toDateTimeString(),'授信结果'=>'失败：日志保存失败']);
                    return $this
                        ->response()
                        ->error('授信失败')
                        ->refresh();
                }
                Log::channel('asses')->info('给商户授信',['uid'=>$id,'amount'=>$input['amount'],'time'=>now()->toDateTimeString(),'授信结果'=>'成功']);
                return $this
                    ->response()
                    ->success('授信成功')
                    ->refresh();
            }else{
                Log::channel('asses')->info('给商户授信',['uid'=>$id,'amount'=>$input['amount'],'time'=>now()->toDateTimeString(),'授信结果'=>'失败：金额保存失败']);
                return $this
                    ->response()
                    ->error('授信失败')
                    ->refresh();
            }
        }else{
            Log::channel('asses')->info('给商户授信',['uid'=>$id,'amount'=>$input['amount'],'time'=>now()->toDateTimeString(),'授信结果'=>'失败：用户不存在']);
            return $this
                ->response()
                ->error('授信的这个用户不存在')
                ->refresh();
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $id = $this->payload['id'] ?? null;
        $ids=Administrator::find($id);
        $this->confirm('确认这个操作吗?', '授信用户'.$ids->username);
        if($ids){
            $this->display('id','授信用户账户')->default($ids->username);
        }else{
            $this->display('id','授信用户账户')->help('当前用户已经不存在了');
        }
        $this->display('myamount','我的余额')->default(Balance::whereUid(Admin::user()->id)->value('balance'));
        $this->number('amount','授信金额')->min(100)->help('授信最小额度大于等于100')->required();
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'name'  => 'John Doe1',
            'email' => 'John.Doe@gmail.com',
        ];
    }
}
