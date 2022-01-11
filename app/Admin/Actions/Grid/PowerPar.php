<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\PowerParForm;
use App\Admin\Forms\UserCreditForm;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PowerPar extends RowAction
{
    /**
     * @return string
     */
	protected $title = '电费折扣调整';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
//         dump($request->all());

        return $this->response()
            ->success('Processed successfully: '.$this->getKey())
            ->refresh();
    }

    public function render()
    {
        $form =PowerParForm::make()->payload(['id' => $this->getKey()]);
        return Modal::make()
            ->lg()
            ->delay(10) // loading 效果延迟时间设置长一些，否则图表可能显示不出来
            ->title($this->title)
            ->body($form)
            ->button($this->title);
    }
    /**
	 * @return string|array|void
	 */
//	public function confirm()
//	{
//
//		 return ['确认这个操作吗?', '授信用户'.$this->getKey()];
//	}
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
     * 传递参数
     * @return array
     */
    protected function parameters()
    {
        $id = $this->getKey();
        return ['id'=>$id];
    }
}
