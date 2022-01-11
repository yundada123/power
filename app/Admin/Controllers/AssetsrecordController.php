<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Assetsrecord;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AssetsrecordController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('余额记录')
            ->description()
            ->body($this->grid());
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Assetsrecord(['user','Puser']), function (Grid $grid) {
            $grid->model()->orderByDesc('created_at');
            $grid->model()->where('uid',Admin::user()->id);
            if(Admin::user()->inRoles(['administrator'])){

            }elseif(Admin::user()->inRoles(['agent'])){

            }elseif(Admin::user()->inRoles(['Merchants'])){

            }
            $grid->column('ls','账户')->display(function (){
                return $this->user->username;
            });
            $grid->column('lss','昵称')->display(function (){
                return $this->user->name;
            });
//            $grid->column('user.username','用户');
            if(Admin::user()->isRole('administrator')){
                $grid->column('role','角色')->display(function ($role){
                    $temp=[0=>'未知',1=>'代理商',2=>'商户'];
                    return $temp[$role];
                })->label([
                    0 => 'danger',
                    1 => 'warning',
                    2 => 'success',
                ]);
            }
//            $grid->column('before');
            $grid->column('balance')->display(function ($bal){
                if($this->type==1){
                    return '+'.$bal;
                }elseif ($this->type==2){
                    return '-'.$bal;
                }
            });
            $grid->column('after');
//            $grid->column('type')->display(function ($type){
//                $temp=[
//                  1=>'授信',
//                  2=>'扣款'
//                ];
//                return $temp[$type];
//            });
//            $grid->column('aid')->display(function ($aid){
//                if($aid==1){
//                    return '系统';
//                }else{
//                    return Administrator::where('id',$aid)->value('username');
//                }
//            });
            $grid->column('orderid');
            $grid->column('xftype')->display(function ($xf){
                if($xf==1){
                    return '系统授信';
                }elseif($xf==2){
                    return '代理授信';
                }elseif($xf==3){
                    return '电费充值';
                }elseif($xf==4){
                    return '电费退款';
                }
            });
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableCreateButton();//创建按钮
            $grid->filter(function (Grid\Filter $filter) {
//                $filter->equal('id');
                $filter->equal('user.username','用户名');
                $filter->equal('user.name','昵称');
                $filter->equal('orderid','订单号');
                $filter->equal('xftype','类型')->select([3=>'电费充值',4=>'电费退款']);

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Assetsrecord(), function (Show $show) {
            $show->field('id');
            $show->field('uid');
            $show->field('before');
            $show->field('balance');
            $show->field('after');
            $show->field('type');
            $show->field('aid');
            $show->field('orderid');
            $show->field('xftype');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Assetsrecord(), function (Form $form) {
            $form->display('id');
            $form->text('uid');
            $form->text('before');
            $form->text('balance');
            $form->text('after');
            $form->text('type');
            $form->text('aid');
            $form->text('orderid');
            $form->text('xftype');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
