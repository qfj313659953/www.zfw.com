<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LoginController extends Controller
{
    //显示登录界面
    public function index()
    {
        return view('admin.login.index');
    }

    //登录功能
    public function login(Request $request)
    {
        //dump($request->all());
        //表单验证
        $data = $this->validate($request,[
            'username' => 'required|min:5|max:8',
            'password' => 'required'
        ]);
       $bool = auth()->attempt($data);
        dump($bool);
        dump(auth()->user());

    }

}
