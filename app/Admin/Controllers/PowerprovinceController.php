<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Powerprovince;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Str;

class PowerprovinceController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Powerprovince(), function (Grid $grid) {
//            $grid->column('id')->sortable();
            $grid->column('show_name');
            $grid->column('power_id');
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
        return Show::make($id, new Powerprovince(), function (Show $show) {
            $show->field('id');
            $show->field('province_name');
            $show->field('status');
            $show->field('power_id');
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
        return Form::make(new Powerprovince(), function (Form $form) {
//            $form->display('id');
            $form->text('province_name')->help('这是实际提交的省份');
            $form->text('show_name')->help('这是显示在用户端的省份');
            $form->text('power_id')->default(function (){
                $pdata=\App\Models\Powerprovince::orderBy('id','desc')->first();
                return  Str::padLeft($pdata->id+1,3,'10');
            });
            $form->radio('status')->options([0=>'维护',1=>'启用'])->default(1);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
