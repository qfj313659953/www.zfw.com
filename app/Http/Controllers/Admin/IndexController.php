<?php

namespace App\Http\Controllers\Admin;

use App\Model\Fang;
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
        //已租
        $count1 = Fang::where('fang_status',1)->count();
        //未租
        $count2 = Fang::where('fang_status',0)->count();

        //拼接图片所需数据
        $legend = "'已租','未租'";
        $data = [
            ['value' => $count1,'name' => '已租'],
            ['value' => $count2,'name' => '未租']
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);



        return view('admin.index.welcome',compact('data','legend'))->with('success','登录成功');
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
