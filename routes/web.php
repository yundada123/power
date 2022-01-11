<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Router;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create so        mething great!
|
*/
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::group([
    'prefix'=>'Merchants',
    'namespace'=>'\App\Http\Controllers\Merchants',
    'middleware'=>['web'],
],function (Router $route){
    $route->get('login','LoginController@getlogin');
    $route->get('index','IndexController@index');
    $route->post('login','LoginController@authenticate');
    $route->get('logout','LoginController@logout');
});
