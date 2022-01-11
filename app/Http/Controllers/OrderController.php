<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public $intfacelist=[];
    public function __construct()
    {
        session_start();/*开启会话*/
        if(!$this->login_status){
            return response()->redirectTo('login',302);
        }
        $this->intfacelist=[url('orderlist')];

    }

    public function index()
    {
        $user=$_SESSION[$_COOKIE['PHPSESSID'].'user'];

        return view('views.index')->with(['user'=>$user]);
    }
    public function orderlist(){

    }


}
