<?php

namespace App\Http\Controllers\Admin;

use App\Model\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //首页展示
    public function index()
    {

        //获取闪存后，再存到闪存中
        session()->flash('success',session('success'));

        //获取当前用户对象
        $userModel = auth()->user();
        //获取当前用户的角色对象
        $roleModel = $userModel->role;
        //判断是否是超级管理员
        if($userModel->username != 'admin'){
            //普通用户
            $authData = $roleModel->nodes()->where('is_menu','1')->get(['id','pid','route_name','name'])->toArray();
        }else{
            //超级管理员
            $authData = Node::where('is_menu','1')->get(['id','pid','route_name','name'])->toArray();
        }
        //转化成树状级
        $menuData = get_tree_list($authData);

        return view('admin.index.index',compact('menuData'));
    }

    //欢迎页
    public function welcome()
    {
        return view('admin.index.welcome')->with('success','登录成功');
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
