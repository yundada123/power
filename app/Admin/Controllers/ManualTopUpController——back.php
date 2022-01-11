<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Tab;
use Illuminate\Support\Facades\Request;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;
//@ini_set('memory_limit', '512M');
class ManualTopUpController
{


    protected $options = [
        1 => '显示文本框',
        2 => '显示编辑器',
    ];

    public function index(Content $content)
    {

//        if (request()->getMethod() == 'POST') {
//            $content->row(Box::make('POST', $this->dump(request()->except(['_pjax', '_token','_t','_remove_'])))->style('default'));
//        }

        $this->dump(request()->except(['_pjax', '_token','_t','_remove_']));
        $content->row(function (Row $row) {
            $tab = new Tab();
            $tab->add('手动充值', $this->form(), true);
            $row->column(12, $tab->withCard());
        });

        return $content
            ->header('手动充值')
            ->description("张家口市,秦皇岛市,廊坊市,承德市,唐山市 请选择[冀北]，内蒙古请选择[蒙东]");
    }


    protected function form()
    {
        $form = new Form();
//        $form->action(request()->fullUrl());
        $i = 0;
        $form->table('电费充值', function (NestedForm $table) use ($i) {
//            $table->number('id','编号')->value($i++);
            $table->text('hid', '账号');
            $table->select('address', '省份')->options(['北京', '天津', '辽宁', '江苏', '浙江', '山东', '湖南', '陕西', '安徽', '重庆', '福建', '河南', '青海', '湖北', '黑龙江', '吉林', '上海', '甘肃', '山西', '四川', '江西', '河北', '蒙东', '冀北']);
            $table->text('amount', '充值金额');
        });

        return $form->render();
    }

//    public function store(Request $request)
//    {
//        dd($this->form());
//    }

    protected function dump($content)
    {

        VarDumper::setHandler(function ($data) {
            $cloner = new VarCloner();
            $dumper = new HtmlDumper();
            $dumper->dump($cloner->cloneVar($data));
        });
        ob_flush();
        ob_start();
        VarDumper::dump($content);

        $content = ob_get_contents();
        ob_end_clean();
//        if (!is_null($content)) {
////            $content=new Content();
//            $content->row(Box::make('修改结果', $content));
//        }
//        admin_error('这个用户不存在');
        return $content;
    }
    public function pdata(){
        $form=new \Dcat\Admin\Form();
        $form->action(request()->fullUrl());
        $form->number('123');
        $form->saved(function (Form $form) {
            return $form->response()->success('保存成功')->redirect('auth/user');
        });
        return $form->render();
    }
}
