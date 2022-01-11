<?php

namespace App\Admin\Metrics\Examples;

use App\Models\Balance;
use App\Models\Order;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\RadialBar;
use Illuminate\Http\Request;

class Tickets extends RadialBar
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $this->title('账户信息');
        $this->height(400);
        $this->chartHeight(300);
        $this->chartLabels('成功率');
//        $this->dropdown([
//            '7' => 'Last 7 Days',
//            '28' => 'Last 28 Days',
//            '30' => 'Last Month',
//            '365' => 'Last Year',
//        ]);
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
            case '365':
            case '30':
            case '28':
            case '7':
            default:
                // 卡片内容
                $yue=Balance::whereUid(Admin::user()->id)->value('balance');
                $this->withContent($yue);//余额
                // 卡片底部
                if(Admin::user()->isRole('administrator')){
                    $successorder=Order::where('status',3)->count('id');
                    $failorder=Order::whereIn('status',[2,4])->count('id');
                    $ingorder=Order::whereIn('status',[0,1])->count('id');
                }elseif (Admin::user()->isRole('agent')){
                    $successorder=Order::where('status',3)->where('pid',Admin::user()->id)->count('id');
                    $failorder=Order::whereIn('status',[2,4])->where('pid',Admin::user()->id)->count('id');
                    $ingorder=Order::whereIn('status',[0,1])->where('pid',Admin::user()->id)->count('id');
                }elseif (Admin::user()->isRole('Merchants')){
                    $successorder=Order::where('status',3)->where('pid',Admin::user()->id)->count('id');
                    $failorder=Order::whereIn('status',[2,4])->where('pid',Admin::user()->id)->count('id');
                    $ingorder=Order::whereIn('status',[0,1])->where('pid',Admin::user()->id)->count('id');
                }
                $this->withFooter($successorder, $failorder, $ingorder);//成功条数   失败条数  充值中
                // 图表数据
        if($successorder===0){
            $this->withChart(0);
        }else{
            $this->withChart($successorder/($failorder+$successorder));
        }
        }
    }

    /**
     * 设置图表数据.
     *
     * @param int $data
     *
     * @return $this
     */
    public function withChart(int $data)
    {
        return $this->chart([
            'series' => [$data],
        ]);
    }

    /**
     * 卡片内容
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex flex-column flex-wrap text-center">
    <h1 class="font-lg-2 mt-2 mb-0">{$content}</h1>
    <small>余额</small>
</div>
HTML
        );
    }

    /**
     * 卡片底部内容.
     *
     * @param string $new
     * @param string $open
     * @param string $response
     *
     * @return $this
     */
    public function withFooter($new, $open, $response)
    {
        return $this->footer(
            <<<HTML
<div class="d-flex justify-content-between p-1" style="padding-top: 0!important;">
    <div class="text-center">
        <p>成功条数</p>
        <span class="font-lg-1">{$new}</span>
    </div>
    <div class="text-center">
        <p>失败条数</p>
        <span class="font-lg-1">{$open}</span>
    </div>
    <div class="text-center">
        <p>充值中</p>
        <span class="font-lg-1">{$response}</span>
    </div>
</div>
HTML
        );
    }
}
