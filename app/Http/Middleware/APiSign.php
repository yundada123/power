<?php

namespace App\Http\Middleware;

use App\Models\Powerprovince;
use App\Models\Shop;
use App\Models\User;
use Closure;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Support\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class APiSign
{
    public $user;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::channel('reapi')->info('接口入参',$request->all());
        try {
            if (!$request->has($this->ApiParam('chongzhi'))) {
                return Helper::json_msg(101, '参数缺失');
            }
            $user = Administrator::where('username', $request->code)->first();
            if (time() > $request->time + 60) {
                // return Helper::json_msg(114,'时间戳超时');
            }
            if (!$user) {
                return Helper::json_msg(110, '商户不存在');
            }
            if ($user->amount < $request->price) {
                return Helper::json_msg(112, '余额不足');
            }
            $shop = Shop::where('shop_price', $request->price)->whereStatus(1)->first();
            if (!$shop) {
                return Helper::json_msg(113, '该面值不存在或者在维护中');
            }
            $province = Powerprovince::where('power_id', $request->province)->whereStatus(1)->first();
            if (!$province) {
                return Helper::json_msg(114, '该省份不存在或者在维护中');
            }
            $cs = $request->all();
            unset($cs['sign']);
            $key = $user->apikey;
            ksort($cs);
            $sign = strtoupper(md5(urldecode(http_build_query($cs)) . '&key=' . $key));
            if ($sign != $request->sign) {
                Log::channel('reapi')->info('解密出参', ['系统生成' => $sign, '接口传参' => $request->sign]);
                return Helper::json_msg(111, 'sign鉴权失败');
            }
            $request->offsetSet('user', $user->toArray());
            $request->offsetSet('shop', $shop->toArray());
            $request->offsetSet('province_modal', $province->toArray());
        }catch (\Exception $e){
            Log::channel('reapi')->error('系统错误',[
                '出错行'=>$e->getLine(),
                '出错文件'=>$e->getFile(),
                '出错编码'=>$e->getCode(),
                '出错描述'=>$e->getMessage(),
                '出错详情'=>$e->getTraceAsString(),
            ]);
            return Helper::json_msg(999, '系统错误');
        }
        $response = $next($request);
        //执行之后的逻辑
        $data['response']=$response->original;
        Log::channel('reapi')->info('接口出参',$data);
        return $response;
    }
    public function ApiParam($apiIntfacs=''){
        //商户号,订单号,价格,省份,时间戳,回调地址,签名
        $pardata=[
          'chongzhi'=>['code','orderid','price','account','province','time','notify','sign']
        ];
        if($apiIntfacs){
            return $pardata[$apiIntfacs];
        }else{
            return $pardata;
        }
    }
}
