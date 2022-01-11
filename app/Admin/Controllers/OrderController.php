<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples\OrderTotal;
use App\Admin\Repositories\Order;
use Dcat\Admin\Admin;
use App\Admin\Metrics\Examples\NewDevices;
use App\Admin\Metrics\Examples\NewUsers;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;
use Illuminate\Database\Eloquent\Model;

class OrderController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('订单列表')
            ->description()
//            ->body(function (Row $row) {
//                $row->column(4, new OrderTotal());
////                $row->column(4, new NewUsers());
////                $row->column(4, new NewDevices());
//            })
            ->body($this->grid());
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Order(['Puser','piduser']), function (Grid $grid) {
            $grid->tableCollapse(false);
            $grid->model()->orderByDesc('id');
            $grid->header(function ($collection) use ($grid) {
                $query = \App\Models\Order::query();

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
            if(Admin::user()->inRoles(['administrator'])){
                $grid->column('id')->sortable();
            }else{
                $grid->model()->where('user_id',Admin::user()->id);
            }
            $grid->column('puser.username','账户名');
            $grid->column('orderid','系统订单号')->copyable();
            $grid->column('u_order_id','商户订单号');
            if(Admin::user()->inRoles(['administrator'])){
                $grid->column('p_order_id');

            }
            $grid->column('acco');
            $grid->column('type')->display(function ($type){
                return [1=>'电费',2=>'话费'][$type];
            });
            $grid->column('order_price','订单面值');
            $grid->column('kk_amount','实际扣款');
            if(Admin::user()->inRoles(['administrator'])){
                $grid->column('status')->display(function ($status){
                    return [0=>'已入库',1=>'上游提交成功',2=>'上游提交失败',3=>'充值成功',4=>'充值失败'][$status];
                });
                $grid->column('notify');
                $grid->column('notify_status')->bool();
                $grid->column('notify_msg');
                $grid->column('created_at','充值时间');
                $grid->column('source')->display(function ($s){
                    return [1=>'api接口',2=>'手工充值'][$s];
                });
                $grid->column('updated_at','完成时间')->display(function ($uptime){
                    if(in_array($this->status,[0,1])){
                        return "";
                    }else{
                        return $uptime;
                    }
                })->sortable();
            }
            if(Admin::user()->inRoles(['agent','Merchants'])){
                $grid->column('status')->display(function ($status){
                    return [0=>'充值中',1=>'充值中',2=>'充值失败,已退款',3=>'充值成功',4=>'充值失败,已退款'][$status];
                });
                $grid->column('source')->display(function ($s){
                    return [1=>'api接口',2=>'手工充值'][$s];
                });
                $grid->column('created_at','充值时间');
                $grid->column('updated_at','完成时间')->display(function ($uptime){
                    if(in_array($this->status,[0,1])){
                        return "";
                    }else{
                        return $uptime;
                    }
                })->sortable();
            }
            $grid->disableCreateButton();//创建按钮

            if(!Admin::user()->inRoles(['administrator'])){
                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->disableDelete();
                    $actions->disableEdit();
                    $actions->disableQuickEdit();
                    $actions->disableView();

                });
            }
            $grid->filter(function (Grid\Filter $filter) {
//                $filter->equal('id');
//                $filter->panel();
                if(Admin::user()->inRoles(['administrator'])){
                    $filter->equal('puser.username','账户名');
                    $filter->like('puser.name','昵称');
                    $filter->equal('orderid');
                    $filter->equal('p_order_id');
                    $filter->equal('u_order_id');
                    $filter->equal('acco');
                    $filter->equal('piduser.username','上级账户');
                    $filter->in('status')->multipleSelect([0=>'已入库',1=>'上游提交成功',2=>'上游提交失败',3=>'充值成功',4=>'充值失败']);
                }elseif(Admin::user()->inRoles(['agent'])){
                    $filter->equal('puser.username','账户名');
                    $filter->like('puser.name','昵称');
                    $filter->equal('orderid');
                    $filter->equal('u_order_id','商户订单号');
                    $filter->equal('acco');
                    $filter->in('status')->multipleSelect([0=>'已入库',1=>'充值中',2=>'充值失败,已退款',3=>'充值成功',4=>'充值失败,已退款']);
                }elseif (Admin::user()->inRoles(['Merchants'])){
                    $filter->equal('orderid');
                    $filter->equal('u_order_id','商户订单号');
                    $filter->equal('acco');
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
