<?php

namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Tab;

class ManualTopUpController extends Controller
{


    public function index(Content $content)
    {


//        $content->row(new Card(new \App\Admin\Forms\Chongzhi()));

        $content->row(function (Row $row) {
            $type = request('_t', 1);

            $tab = new Tab();

            if ($type == 1) {
                $tab->add('电费充值', new \App\Admin\Forms\Chongzhi(),true);
//                $tab->addLink('电费充值', request()->fullUrlWithQuery(['_t' => 2]));
            }
//            else {
//                $tab->add('话费充值',  new Chongzhi());
//                $tab->addLink('话费充值', request()->fullUrlWithQuery(['_t' => 1]));
//            }

            $row->column(12, $tab->withCard());
        });

        return $content
            ->header('手动充值')
            ->description('<p style="color: red">注意事项--省份中河北没有列出来的市统一选择河北</p>');
    }


}
