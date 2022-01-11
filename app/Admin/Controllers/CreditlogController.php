<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Creditlog;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CreditlogController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Creditlog(), function (Grid $grid) {
            $grid->model()->orderByDesc('id');
            if(Admin::user()->inRoles(['agent'])){
                $grid->model()->where(function ($quest){
                    $quest->where('uid',Admin::user()->id)
                        ->where('type',2);
                })->orWhere(function ($quest){
                    $quest->where('pid',Admin::user()->id)
                        ->where('type',1);
                })->orderByDesc('id');
            }elseif (Admin::user()->inRoles(['Merchants'])){
                $grid->model()->where(function ($quest){
                    $quest->where('uid',Admin::user()->id)
                        ->where('type',2);
                });
            }
//            $grid->column('id')->sortable();
            $grid->column('pid')->display(function ($pid){
                if($pid==1){
                    return '系统';
                }else{
                    $u=Administrator::find($pid);
                    return $u->name;
                }
            });
            $grid->column('amount');
            $grid->column('uid')->display(function ($uid){
//                return $uid;
                $u=Administrator::find($uid);
                return $u->name;
            });
            $grid->column('aamount');
            $grid->column('bamount');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableCreateButton();//创建按钮
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
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
        return Show::make($id, new Creditlog(), function (Show $show) {
            $show->field('id');
            $show->field('pid');
            $show->field('amount');
            $show->field('uid');
            $show->field('aamount');
            $show->field('bamount');
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
        return Form::make(new Creditlog(), function (Form $form) {
            $form->display('id');
            $form->text('pid');
            $form->text('amount');
            $form->text('uid');
            $form->text('aamount');
            $form->text('bamount');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
