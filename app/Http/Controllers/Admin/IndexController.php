<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //首页展示
    public function index()
    {
        return view('admin.index.index');
    }

    //欢迎页
    public function welcome()
    {
        return view('admin.index.welcome');
    }

    //退出登录
    public function logout()
    {
        //退出登录
        auth()->logout();
        //退出成功返回到登录页
        return redirect(route('admin.login'))->with('success','登录退出成功');

    }





}
