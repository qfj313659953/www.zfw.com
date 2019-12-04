<?php

namespace App\Http\Middleware;

use Closure;

class CheckApi
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
       $username = $request->header('username');
       $password = $request->header('password');
       $sign = $request->header('sign');
       $timestamp = $request->header('timestamp');
       //dump($password);
       //根据账号和密码进行登录
        $bool = auth()->guard('api')->attempt(['username'=>$username,'password'=>$password]);
       // dump($bool);
        //只有登录 后才可以验证
        if(!$bool){
            return response()->json(['status' => 0,'msg'=>'登录异常','data'=>[]],401);
        }
        $token = auth()->guard('api')->user()->token;
        //验签
        $signate = md5($username.$token.$password.$timestamp);

        if($sign != $signate){
            return response()->json(['status' => 0,'msg'=>'登录异常1','data'=>[]],401);
        }

        return $next($request);


    }
}
