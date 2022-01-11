<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Myorderlist;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class MyorderlistController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Myorderlist(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('orderid');
            $grid->column('province_name');
            $grid->column('acco');
            $grid->column('amount');
            $grid->column('kk_amount');
            $grid->column('status')->bool();
            $grid->column('type')->display(function ($type){
                return [1=>'电费',2=>'话费'][$type];
            });
            $grid->column('msg');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
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
        return Show::make($id, new Myorderlist(), function (Show $show) {
            $show->field('id');
            $show->field('orderid');
            $show->field('province_name');
            $show->field('acco');
            $show->field('amount');
            $show->field('kk_amount');
            $show->field('status');
            $show->field('type');
            $show->field('msg');
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
        return Form::make(new Myorderlist(), function (Form $form) {
            $form->display('id');
            $form->text('orderid');
            $form->text('province_name');
            $form->text('acco');
            $form->text('amount');
            $form->text('kk_amount');
            $form->text('status');
            $form->text('type');
            $form->text('msg');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
