<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\PUserCreditForm;
use App\Admin\Repositories\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Models\Role;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Str;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('pid')->display(function ($pid){
                return Administrator::whereId($pid)->value('name');
            });
            $grid->column('name');
            $grid->column('email');
//            $grid->column('order');
//            $grid->column('remember_token');
            $grid->column('amount');
            $grid->column('power_par');
            $grid->column('status')->bool();
            $grid->column('apikey');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->actions(PUserCreditForm::make());
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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('pid');
            $show->field('name');
            $show->field('email');
            $show->field('password');
            $show->field('remember_token');
            $show->field('amount');
            $show->field('status');
            $show->field('apikey');
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
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->select('pid')->options(function (){
                $admin=new Administrator();
                return $admin->whereHas('roles', function ($query) {
                    $query->where('slug', 'agent');
                })->pluck('name','id');
            });
            $id = $form->getKey();
            $form->text('name')->required()
                ->creationRules(['required', "unique:users"])
                ->updateRules(['required', "unique:users,name,$id"]);
            $form->text('email');
            $form->text('password')->default(123456)->value(bcrypt(123456));
            $form->text('apikey')->default(Str::random(32));
            $form->number('power_par');
            $form->radio('status')->options([1=>'启用',2=>'禁用'])->default(1);
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
