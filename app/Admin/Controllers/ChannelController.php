<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\UserCredit;
use App\Admin\Repositories\Channel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ChannelController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Channel(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('desc');
            $grid->column('user');
            $grid->column('pwd');
            $grid->column('admin_url');
            $grid->column('api_acco');
            $grid->column('api_key');
            $grid->column('api_url');
            $grid->column('status')->radio([1=>'启用',0=>'禁用']);
            $grid->column('discount');
            $grid->column('created_at');
//            $grid->column('updated_at')->sortable();
//            $grid->enableDialogCreate();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
            $grid->actions(UserCredit::make());
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
        return Show::make($id, new Channel(), function (Show $show) {
            $show->field('id');
            $show->field('user');
            $show->field('pwd');
            $show->field('admin_url');
            $show->field('api_acco');
            $show->field('api_key');
            $show->field('api_url');
            $show->field('status');
            $show->field('desc');
            $show->field('discount');
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
        return Form::make(new Channel(), function (Form $form) {
            $form->display('id');
            $form->text('user');
            $form->text('pwd');
            $form->url('admin_url');
            $form->text('api_acco');
            $form->text('api_key');
            $form->url('api_url');
            $form->radio('status')->options([1=>'启用',0=>'禁用'])->default(1);
            $form->textarea('desc');
            $form->text('discount');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
