<?php

namespace App\Admin\Forms;

use App\Models\Assetsrecord;
use App\Models\Balance;
use Carbon\Carbon;
use Dcat\Admin\Admin;
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

class PowerParForm extends Form implements LazyRenderable
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
        $ids = Administrator::find($id);
//        dd($id,$ids,$input['power_par']);
        if(Admin::user()->inRoles(['agent'])){
            if($input['power_par']<0){
                return $this
                    ->response()
                    ->error('电费折扣调整失败,折扣错误')
                    ->refresh();
            }

        }
        DB::beginTransaction();
        if ($ids) {
            $ss = Balance::where('uid', $id)->update(['power_par'=>$input['power_par']]);
            if ($ss) {
                DB::commit();
                Log::channel('asses')->info('电费折扣调整', ['uid' => $id, 'power_par' => $input['power_par'], 'time' => now()->toDateTimeString(), '授信结果' => '成功']);
                return $this
                    ->response()
                    ->success('处理成功')
                    ->refresh();
            } else {
                DB::rollBack();
                Log::channel('asses')->info('电费折扣调整', ['uid' => $id, 'power_par' => $input['power_par'], 'time' => now()->toDateTimeString(), '授信结果' => '失败：日志保存失败']);
                return $this
                    ->response()
                    ->error('处理失败')
                    ->refresh();
            }
        } else {
            Log::channel('asses')->info('电费折扣调整', ['uid' => $id, 'power_par' => $input['power_par'], 'time' => now()->toDateTimeString(), '授信结果' => '失败：用户不存在']);
            return $this
                ->response()
                ->error('处理的这个用户不存在')
                ->refresh();
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $id = $this->payload['id'] ?? null;
        $ids = Administrator::find($id);
        $this->confirm('确认这个操作吗?', '调整用户' . $ids->username);
        if ($ids) {
            $this->display('id', '用户账户')->default($ids->username);
        } else {
            $this->display('id', '用户账户')->help('当前用户已经不存在了');
        }
        $this->text('power_par', '折扣调整为：')->help('该比例使用百分比,请填写100以内的整数')->required();
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
