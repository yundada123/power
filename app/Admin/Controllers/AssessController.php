<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\PowerPar;
use App\Admin\Actions\Grid\UserCredit;
use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Http\Repositories\Administrator;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class AssessController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('资产管理')
            ->description('')
            ->body($this->grid());
    }

    public function grid()
    {
        return Grid::make(Administrator::with(['roles','balance']), function (Grid $grid) {
            $grid->model()->where('id','!=',1);
            $grid->model()->orderByDesc('created_at');
            $grid->column('id', 'ID')->sortable();
            $grid->column('username');
            $grid->column('name');
            $grid->column('balance.power_par','电费折扣');
            $grid->column('balance.balance','余额');
            $grid->actions(UserCredit::make());
            $grid->actions(PowerPar::make());
            // 禁用删除按钮
            $grid->disableDeleteButton();
            // 禁用快捷编辑按钮
            $grid->disableQuickEditButton();
        });
    }
}
