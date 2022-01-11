<?php

namespace App\Admin\Controllers;


use App\Events\PowerEvent;
use App\Events\SendHttpMessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function index(Request $request){
        $mobile='17092895598';
        $phone = json_decode(file_get_contents("https://cx.shouji.360.cn/phonearea.php?number=".$mobile),1)["data"];
        dd($phone);
        $order=Order::find(1);
//        event(new PowerEvent($order));
//        $s=event(new SendHttpMessageEvent($order));
//        dd($s);
    }

}
