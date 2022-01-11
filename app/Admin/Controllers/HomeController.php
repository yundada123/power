<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('首页')
            ->description('这是通知')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row(new Examples\Tickets());
//                    $column->row($this->build());
                });

//                $row->column(6, function (Column $column) {
////                    $column->row(new \App\Admin\Forms\Chongzhi());
//                    $column->row(function (Row $row) {
//                        $row->column(6, new Examples\NewUsers());
//                        $row->column(6, new Examples\NewDevices());
//                    });
//
//                    $column->row(new Examples\ProductOrders());
//                });
            });
    }
}
