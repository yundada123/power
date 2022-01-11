<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Login extends Controller
{
    public $login_status=false;
    public function __construct()
    {
        session_start();/*开启会话*/
//        $this-
//        dd($_SESSION);
        if(!$this->login_status){
            return response()->redirectTo('login',302);
        }

    }

    public function index(){
        return view('login.index');
    }

    public function dologin(Request $request)
    {

        $username=$request->username;
        $pwd=$request->pwd;
        $validator=Validator::make($request->all(),[
            'username'=>'required',
            'pwd'=>'required|min:6',
        ]);
//        dd($validator->errors());
        if($validator->fails()){
            return response()->json([
                'code'=>9,
                'msg'=>'账户名或者密码不正确'
            ],200);
        }

        if(empty($username) || empty($pwd)){
            return response()->json([
                'code'=>9,
                'msg'=>'账户名或者密码为空'
            ],200);
        }
        $user=User::where('name',$username)->where('password',$pwd)->first();
        if(empty($user)){
            return response()->json([
                'code'=>9,
                'msg'=>'账户名或者密码不正确'
            ],200);
        }else{
            $_SESSION[$_COOKIE['PHPSESSID'].'user']=$user;
            $_SESSION[$_COOKIE['PHPSESSID'].'login_status']=true;
            $this->login_status=true;
//            return redirect('index')->with('message', '欢迎登录');
            return response()->json([
                'code'=>1,
                'msg'=>'登录成功',
                'url'=>url('index')
            ],200);
        }


    }

    public function index2()
    {
        $user=$_SESSION[$_COOKIE['PHPSESSID'].'user'];

        return view('views.index')->with(['user'=>$user]);
    }
    public function logout(){

//        dd($_COOKIE['PHPSESSID']);
        unset($_SESSION['user']);//销毁用户名
        unset($_COOKIE['PHPSESSID']);//销毁昵称
        return response()->redirectTo('login');
    }

}
