<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Phoneorder;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PhoneorderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Phoneorder(['puser']), function (Grid $grid) {
//            $grid->column('id')->sortable();
//            $grid->column('uid');
            $grid->model()->orderByDesc('id');
            $grid->header(function ($collection) use ($grid) {
                $query = \App\Models\Phoneorder::query();

//                // 拿到表格筛选 where 条件数组进行遍历
                $grid->model()->getQueries()->unique()->each(function ($value) use (&$query) {
//                    dd($query,$value);
                    if (in_array($value['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) {
                        return;
                    }

                    $query = call_user_func_array([$query, $value['method']], $value['arguments'] ?? []);
                });
//
//                // 查出统计数据
                $data = $query->get();
                $successamount=0;//成功总金额
                $failamount=0;//失败总金额
                $ingamount=0;
                $countamount=0;
                $kk_zmonut=0;
                foreach ($data as $v){
                    if(in_array($v->status,[0,1])){//充值中
                        $ingamount+=$v->order_price;
                        $kk_zmonut+=$v->kk_amount;
                    }elseif (in_array($v->status,[2,4])){//失败
                        $failamount+=$v->order_price;
                    }elseif($v->status==3){//成功
                        $successamount+=$v->order_price;
                        $kk_zmonut+=$v->kk_amount;
                    }

                    $countamount+=$v->order_price;
                }
                return "
                    <div  style='margin-top:15px'>
    <button class='btn btn-primary  '> 总条数：{$data->count()} </button>&nbsp;&nbsp;
    <button class='btn btn-info  '> 总金额：{$countamount} </button>&nbsp;
    <button class='btn btn-custom  '> 成功总金额：{$successamount} </button>&nbsp;&nbsp;
     <button class='btn btn-success  '> 充值中总金额:{$ingamount} </button>&nbsp;&nbsp;
      <button class='btn btn-warning  '> 失败总金额:{$failamount} </button>&nbsp;&nbsp;
    <button class='btn btn-danger  '> 实际扣款:{$kk_zmonut} </button>&nbsp;&nbsp;
</div>
                ";
            });
            $grid->column('puser.username','账户名');
            $grid->column('phone');
            $grid->column('orderid');
            if(Admin::user()->inRoles(['administrator'])){
                $grid->column('p_order_id');

            }
            $grid->column('u_order_id');
            $grid->column('order_price');
            $grid->column('kk_amount');
            if(Admin::user()->inRoles(['administrator'])){
                $grid->column('status')->display(function ($status){
                    return [0=>'已入库',1=>'上游提交成功',2=>'上游提交失败',3=>'充值成功',4=>'充值失败'][$status];
                });

                $grid->column('notfiy');
                $grid->column('notfiynum');
            }elseif (Admin::user()->inRoles(['agent','Merchants'])){
                $grid->column('status')->display(function ($status){
                    return [0=>'充值中',1=>'充值中',2=>'充值失败,已退款',3=>'充值成功',4=>'充值失败,已退款'][$status];
                });
            }
            $grid->column('type')->display(function ($type){
                    return ['fast_call'=>'快充','slow_call'=>'慢充'][$type];
            });
            $grid->column('province');
            $grid->column('city');
            $grid->column('source')->display(function ($s){
                return [1=>'api接口',2=>'手工充值'][$s];
            });
            $grid->column('note');
            $grid->column('created_at')->sortable();
            $grid->column('updated_at','完成时间')->display(function ($uptime){
                if(in_array($this->status,[0,1])){
                    return "";
                }else{
                    return $uptime;
                }
            })->sortable();

            $grid->disableCreateButton();//创建按钮

//            if(!Admin::user()->inRoles(['administrator'])){
                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->disableDelete();
                    $actions->disableEdit();
                    $actions->disableQuickEdit();
                    $actions->disableView();

                });
//            }
            $grid->filter(function (Grid\Filter $filter) {
                if(Admin::user()->inRoles(['administrator'])){
                    $filter->equal('puser.username','账户名');
                    $filter->like('puser.name','昵称');
                    $filter->equal('orderid');
                    $filter->equal('porderid');
                    $filter->equal('uorderid');
                    $filter->equal('phone');
                    $filter->equal('type')->select(['fast_call'=>'快充','slow_call'=>'慢充']);
                    $filter->equal('piduser.username','上级账户');
                    $filter->in('status')->multipleSelect([0=>'已入库',1=>'上游提交成功',2=>'上游提交失败',3=>'充值成功',4=>'充值失败']);
                }elseif(Admin::user()->inRoles(['agent'])){
                    $filter->equal('puser.username','账户名');
                    $filter->like('puser.name','昵称');
                    $filter->equal('orderid');
                    $filter->equal('uorderid','商户订单号');
                    $filter->equal('phone');
                    $filter->in('status')->multipleSelect([0=>'已入库',1=>'充值中',2=>'充值失败,已退款',3=>'充值成功',4=>'充值失败,已退款']);
                }elseif (Admin::user()->inRoles(['Merchants'])){
                    $filter->equal('orderid');
                    $filter->equal('uorderid','商户订单号');
                    $filter->equal('phone');
                    $filter->in('status')->multipleSelect([0=>'已入库',1=>'充值中',2=>'充值失败,已退款',3=>'充值成功',4=>'充值失败,已退款']);
                }
        
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
        return Show::make($id, new Phoneorder(), function (Show $show) {
            $show->field('id');
            $show->field('uid');
            $show->field('phone');
            $show->field('orderid');
            $show->field('porderid');
            $show->field('uorderid');
            $show->field('notfiynum');
            $show->field('province');
            $show->field('city');
            $show->field('status');
            $show->field('type');
            $show->field('source');
            $show->field('note');
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
        return Form::make(new Phoneorder(), function (Form $form) {
            $form->display('id');
            $form->text('uid');
            $form->text('phone');
            $form->text('orderid');
            $form->text('porderid');
            $form->text('uorderid');
            $form->text('notfiynum');
            $form->text('province');
            $form->text('city');
            $form->text('status');
            $form->text('type');
            $form->text('source');
            $form->text('note');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
