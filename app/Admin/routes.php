<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;
use App\Http\Controllers\Login;
//use \App\Admin\Controllers\Chongzhi;

Admin::routes();
//Route::get('/login',[Login::class,'index']);
//Route::post('/login',[Login::class,'dologin']);
//Route::get('/logout',[Login::class,'logout']);
//Route::get('/index',[\App\Http\Controllers\IndexController::class,'index']);
Route::get('/init',[\App\Http\Controllers\IndexController::class,'getSystemInit']);
//Route::get('/clear',[\App\Http\Controllers\IndexController::class,'clear']);
//Route::get('/order',[\App\Http\Controllers\OrderController::class,'index']);
//Route::post('/order/list',[\App\Http\Controllers\OrderController::class,'orderlist']);

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('myorder', 'OrderController');//订单管理
    $router->resource('phoneorder', 'PhoneorderController');//话费订单管理
    $router->resource('channel', 'ChannelController');//供应商管理
    $router->resource('shop', 'ShopController');//商品管理
    $router->resource('chai', 'OrderchaiController');//拆单记录
    $router->resource('user', 'UserController');//客户管理
    $router->resource('zcjl', 'AssetsrecordController');//资产记录
    $router->resource('asses', 'AssessController');//资产记录
    $router->resource('sxjl', 'CreditlogController');//授信记录
    $router->get('chongzhi', 'ManualTopUpController@index');//电费充值
    $router->post('chongzhi', 'ManualTopUpController@index');//电费充值
    $router->get('phchongzhi', 'PhchongzhiController@index');//话费充值
    $router->post('phchongzhi', 'PhchongzhiController@index');//话费充值
    $router->resource('power_province', 'PowerprovinceController');//电费省份表
    $router->resource('test', 'TestController');//测试
    $router->resource('modelslog', 'ModelLogController');//模型日志
    $router->resource('myorderlist', 'MyorderlistController');//手动充值失败记录
});
