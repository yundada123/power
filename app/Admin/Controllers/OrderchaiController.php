<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Orderchai;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class OrderchaiController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Orderchai(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('orderid');
            $grid->column('c_id');
            $grid->column('status');
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
        return Show::make($id, new Orderchai(), function (Show $show) {
            $show->field('id');
            $show->field('orderid');
            $show->field('c_id');
            $show->field('status');
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
        return Form::make(new Orderchai(), function (Form $form) {
            $form->display('id');
            $form->text('orderid');
            $form->text('c_id');
            $form->text('status');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
