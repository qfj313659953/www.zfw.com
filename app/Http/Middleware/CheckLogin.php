<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->check()){
            //用户没有登录
            return redirect(route('admin.login'))->withErrors('请先登录');
        }
        //获取当前用户的模型
        $userModel = auth()->user();
        //根据当前用户的模型获取用户的角色
        //利用模型关联获取角色对象
        $roleModel = $userModel->role;
        //利用模型关联获取权限
        $auths = $roleModel->nodes()->pluck('route_name','id')->toArray();

        //真正的权限,过滤空数据
        $authList = array_filter($auths);
        //添加一些公共的路由,不需要验证的
        $allowList = [
            'admin.index',
            'admin.welcome',
            'admin.logout'
        ];
        //当前用户权限路由和公共的路由合并
        $authList = array_merge($authList,$allowList);

        //把权限写到request对象中
        $request->auths = $authList;

        //获取当前路由别名
        $currentRouteName = $request->route()->getName();
        //dump($currentRouteName);die;
        //获取当前用户名
        $currentUserName = $userModel->username;
        //把当前用户名写到request对象中
        $request->username = $currentUserName;

        //权限判断
        if(!in_array($currentRouteName,$authList) && $currentUserName != 'admin'){
            exit('你没有权限访问');
        }

        return $next($request);
    }
}
