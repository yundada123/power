<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\PUserCredit;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PUserCreditForm extends RowAction
{
    /**
     * @return string
     */
    protected $title = '用户额度授信';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // dump($this->getKey());

        return $this->response()
            ->success('Processed successfully: '.$this->getKey())
            ->redirect('/');
    }
    public function render()
    {
        $form =PUserCredit::make()->payload(['id' => $this->getKey()]);
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
	public function confirm()
	{
		// return ['Confirm?', 'contents'];
	}
    /**
     * 权限或者角色判断
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return $user->isRole('agent');
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
