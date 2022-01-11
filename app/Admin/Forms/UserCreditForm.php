<?php

namespace App\Admin\Forms;

use App\Models\Assetsrecord;
use App\Models\Balance;
use Carbon\Carbon;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\HasPermissions;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Contracts\LazyRenderable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserCreditForm extends Form implements LazyRenderable
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
        $ids=Administrator::find($id);
        DB::beginTransaction();
        $jl=new Assetsrecord();
        if($ids){
            $jl->uid=$id;
            $jl->before=Balance::whereUid($id)->value('balance');
            $jl->balance=$input['amount'];
            $ss=Balance::where('uid',$id)->increment('balance',$input['amount']);
            if($ss){
                $jl->type=1;
                $jl->aid=1;
                $jl->orderid=Str::random(12);
                $jl->xftype=1;
                $jl->role=1;
                $jl->after=Balance::whereUid($id)->value('balance');
                if($jl->save()){
                    DB::commit();
                }else{
                    DB::rollBack();
                    Log::channel('asses')->info('授信',['uid'=>$id,'amount'=>$input['amount'],'time'=>now()->toDateTimeString(),'授信结果'=>'失败：日志保存失败']);
                    return $this
                        ->response()
                        ->error('授信失败')
                        ->refresh();
                }
                Log::channel('asses')->info('授信',['uid'=>$id,'amount'=>$input['amount'],'time'=>now()->toDateTimeString(),'授信结果'=>'成功']);
                return $this
                    ->response()
                    ->success('授信成功')
                    ->refresh();
            }else{
                Log::channel('asses')->info('授信',['uid'=>$id,'amount'=>$input['amount'],'time'=>now()->toDateTimeString(),'授信结果'=>'失败：金额保存失败']);
                return $this
                    ->response()
                    ->error('授信失败')
                    ->refresh();
            }
        }else{
            Log::channel('asses')->info('授信',['uid'=>$id,'amount'=>$input['amount'],'time'=>now()->toDateTimeString(),'授信结果'=>'失败：用户不存在']);
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
        $this->text('amount','授信金额')->required();
    }
    /**
     * 权限或者角色判断
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return $user->isRole('administrator');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
//    public function default()
//    {
//        $id = $this->payload['id'] ?? null;
//        return [
//            'id'=>$id
//        ];
//    }
}
