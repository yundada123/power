<?php

namespace App\Http\Controllers\Merchants;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * 处理登录认证
     *
     * @return Response
     * @translator laravelacademy.org
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only([$this->username(), 'password']);
        $remember = (bool) $request->input('remember', false);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($credentials, [
            $this->username()   => 'required',
            'password'          => 'required',
        ]);

        if ($validator->fails()) {
          return $validator->errors();
        }

        if (Auth::guard('Merchants')->attempt($credentials,$remember)) {
            // 认证通过...
//            dd(Auth::guard('Merchants')->check());
            return response()->json([
                'code'=>1,
                'msg'=>'登录成功',
                'url'=>url('Merchants/index')
            ]);
            return redirect()->intended('Merchants/index');
        }else{
            return response()->json([
                'code'=>99,
                'msg'=>'账户或者密码错误'
            ]);
        }
    }
    public function getlogin(){
        return view('Merchants.login');
    }
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'name';
    }

    public function logout()
    {
        Auth::logout();
    }

}
