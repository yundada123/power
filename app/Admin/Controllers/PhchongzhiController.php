<?php

namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Tab;

class PhchongzhiController extends Controller
{


    public function index(Content $content)
    {


//        $content->row(new Card(new \App\Admin\Forms\Chongzhi()));

        $content->row(function (Row $row) {
            $tab = new Tab();
            $tab->add('话费充值', new \App\Admin\Forms\PhoneForm(),true);

            $row->column(12, $tab->withCard());
        });

        return $content
            ->header('话费充值')
            ->description('<p style="color: red">注意事项</p>');
    }


}
