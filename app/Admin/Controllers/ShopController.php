<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Shop;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ShopController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Shop(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('shop_name');
            $grid->column('shop_price');
            $grid->column('shop_type')->display(function ($shoptype){
                return [1=>'电费',2=>'话费'][$shoptype];
            });
            $grid->column('shop_par');
            $grid->column('shop_discount');
            $grid->column('shop_msg');
            $grid->column('shop_pic');
            $grid->column('status')->bool();
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
        return Show::make($id, new Shop(), function (Show $show) {
            $show->field('id');
            $show->field('shop_name');
            $show->field('shop_price');
            $show->field('shop_type');
            $show->field('shop_par');
            $show->field('shop_discount');
            $show->field('shop_msg');
            $show->field('shop_pic');
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
        return Form::make(new Shop(), function (Form $form) {
            $form->display('id');
            $form->text('shop_name');
            $form->text('shop_price');
            $form->select('shop_type')->options([1=>'电费',2=>'话费']);
            $form->text('shop_par');
            $form->text('shop_discount');
            $form->textarea('shop_msg');
            $form->image('shop_pic');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
