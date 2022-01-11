<?php

namespace App\Admin\Controllers;


use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Row;
use OwenIt\Auditing\Models\Audit;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;
use Illuminate\Database\Eloquent\Model;

class ModelLogController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('模型日志')
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
        return Grid::make(new Audit(['puser']), function (Grid $grid) {
            $grid->tableCollapse(false);
            $grid->model()->orderByDesc('id');    
            $grid->column('user_type','用户类型');
            $grid->column('puser.name','操作用户')->copyable();
            $grid->column('event','事件');
            $grid->column('auditable_type','记录类型');
            $grid->column('user_id','登录用户');
            $grid->column('old_values.name','旧的记录值');
            $grid->column('old_values.updated_at','旧的记录时间');
            $grid->column('new_values.name','新的记录值');
            $grid->column('new_values.updated_at','新的记录时间');
            $grid->column('url','操作地址');
            $grid->column('ip_address','IP地址');
            $grid->column('user_agent','客户端');
            $grid->column('created_at','记录时间');
            $grid->column('updated_at','更新时间');
           
           
            $grid->disableCreateButton();//创建按钮
                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->disableDelete();
                    $actions->disableEdit();
                    $actions->disableQuickEdit();
                    $actions->disableView();

                });
            $grid->filter(function (Grid\Filter $filter) {
                    $filter->like('puser.name','昵称');
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
        return Show::make($id, new Order(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('orderid');
            $show->field('p_order_id');
            $show->field('u_order_id');
            $show->field('type');
            $show->field('order_price');
            $show->field('notify');
            $show->field('kk_amount');
            $show->field('status');
            $show->field('shop_id');
            $show->field('notify_status');
            $show->field('notify_msg');
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
        return Form::make(new Order(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('orderid');
            $form->text('p_order_id');
            $form->text('u_order_id');
            $form->text('type');
            $form->text('order_price');
            $form->text('notify');
            $form->text('kk_amount');
            $form->text('status');
            $form->text('shop_id');
            $form->text('notify_status');
            $form->text('notify_msg');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
