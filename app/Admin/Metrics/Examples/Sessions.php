<?php

namespace App\Admin\Metrics\Examples;

use App\Admin\Forms\Chongzhi;
use App\Admin\Repositories\NullRepository;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Metrics\Bar;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Http\Request;
use Dcat\Admin\Layout\Content;

class Sessions extends Bar
{

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();

        $dark35 = $color->dark35();
        // 卡片内容宽度
        $this->contentWidth(5, 7);
        // 标题
        $this->title('手动充值');
//        $this->content($this->build());
//        $this->view($this->build());
        // 设置下拉选项
        $this->dropdown([
            '7' => 'Last 7 Days',
            '28' => 'Last 28 Days',
            '30' => 'Last Month',
            '365' => 'Last Year',
        ]);
        // 设置图表颜色
        $this->chartColors([
            $dark35,
            $dark35,
            $color->primary(),
            $dark35,
            $dark35,
            $dark35
        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {

        switch ($request->get('option')) {
            case '7':
              $this->content(new Card( new Chongzhi()));
                break;
            default:
                // 卡片内容
                $this->withContent('2.7k', '+5.2%');

                // 图表数据
                $this->withChart([
                    [
                        'name' => 'Sessions',
                        'data' => [75, 125, 225, 175, 125, 75, 25],
                    ],
                ]);
        }
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => $data,
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $title
     * @param string $value
     * @param string $style
     *
     * @return $this
     */
    public function withContent($title, $value, $style = 'success')
    {
        // 根据选项显示
        $label = strtolower(
            $this->dropdown[request()->option] ?? 'last 7 days'
        );

        $minHeight = '183px';
        Form::dialog('新增角色')
            ->click('.chongzhi')// 绑定点击按钮
            ->url('auth/roles/create')// 表单页面链接，此参数会被按钮中的 “data-url” 属性替换。。
            ->width('700px')// 指定弹窗宽度，可填写百分比，默认 720px
            ->height('650px')// 指定弹窗高度，可填写百分比，默认 690px
            ->success('LA.reload()'); // 新增成功后刷新页面
        $editPage = admin_base_path('auth/roles/1/edit');
        return $this->content(

            <<<HTML
<div class="d-flex p-1 flex-column justify-content-between" style="padding-top: 0;width: 100%;height: 100%;min-height: {$minHeight}">
    <div class="text-left">
        <h1 class="font-lg-2 mt-2 mb-0">{$title}</h1>
        <h5 class="font-medium-2" style="margin-top: 10px;">
            <span class="text-{$style}">{$value} </span>
            <span>vs {$label}</span>
        </h5>
    </div>

    <span class='btn btn-outline-primary chongzhi' data-url='{$editPage}'> &nbsp;&nbsp;&nbsp;电费充值&nbsp;&nbsp;&nbsp; </span> &nbsp;&nbsp;
</div>
HTML
        );
    }
//    protected function build()
//    {
//        Form::dialog('新增角色')
//            ->click('#create-form') // 绑定点击按钮
//            ->url('auth/roles/create') // 表单页面链接，此参数会被按钮中的 “data-url” 属性替换。。
//            ->width('700px') // 指定弹窗宽度，可填写百分比，默认 720px
//            ->height('650px') // 指定弹窗高度，可填写百分比，默认 690px
//            ->success('LA.reload()'); // 新增成功后刷新页面
//
//        return $this->content("
//<div style='padding:30px 0'>
//    <span class='btn btn-outline-primary create-form'> &nbsp;&nbsp;&nbsp;电费充值&nbsp;&nbsp;&nbsp; </span> &nbsp;&nbsp;
//</div>
//");
//    }
}
